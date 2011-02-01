<?php

class Trip_m extends Model {
    
    
    function create_trip($uid, $what) {
        //insert into trips table
        $v = array('name' => $what,
                   );
        list($sql, $values) = $this->mdb->insert_string('trips', $v);
        $tripid = $this->mdb->alter($sql, $values);
        
        //insert into trips_user junction table
        $v = array('uid' => $uid,
                   'tripid' => $tripid,
                   'rsvp' => 'yes',
                   'type' => 'planner'
                   );
        list($sql, $values) = $this->mdb->insert_string('trips_users', $v);
        $this->mdb->alter($sql, $values);
        
        //erase cache        
        $this->mc->delete('trip_by_tripid:'.$tripid);
        $this->mc->delete('tripids_by_uid:'.$uid);
        $this->mc->delete('uids_by_tripid:'.$tripid);
        
        return $tripid;
    }
    

    function get_trip_by_tripid($tripid) {
        $key = 'trip_by_tripid:'.$tripid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM trips WHERE tripid = ? AND active = 1';
            $v = array($tripid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }        
        return $val;
    }

    
    //Move to trips_users_m later
    function get_tripids_by_uid($uid) {
        $key = 'tripids_by_uid:'.$uid;
        $tripids = $this->mc->get($key);
        if($tripids === false) {
            $sql = 'SELECT trips_users.tripid FROM trips_users, trips WHERE trips_users.uid = ? AND trips_users.tripid = trips.tripid AND trips.active = 1';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);
            $tripids = array();
            if($rows) {
                foreach($rows as $row) {
                    $tripids[] = $row['tripid'];
                }
            }
            $this->mc->set($key, $tripids);
        }
        return $tripids;
    }
    
    
    function get_uids_by_tripid($tripid) {
		$key = 'uids_by_tripid:'.$tripid;
	    $uids = $this->mc->get($key);
	    if($uids === false) {
	        $sql = 'SELECT uid FROM trips_users WHERE tripid = ?';
	        $v = array($tripid);
	        $rows = $this->mdb->select($sql, $v);
	        $uids = array();
	        if($rows) {
	            foreach($rows as $row) {
	                $uids[] = $row['uid'];
	            }
	        }
	        $this->mc->set($key, $uids);
	    }
	    return $uids;
    }
    

    function delete_trip($tripid) {
        $trip = $this->get_trip_by_tripid($tripid);
        if(!$trip)
            return false;
        $uid = $this->User_m->get_logged_in_uid();
        if($this->get_type_by_tripid_uid($tripid, $uid) != 'planner')
            return false;

        $sql = 'UPDATE trips SET active = ? WHERE tripid = ?';
        $v = array(0, $tripid);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('tripids_by_uid:'.$uid);
        $this->mc->delete('trip_by_tripid:'.$tripid);
        $this->mc->delete('uids_by_tripid:'.$tripid);
        return true;
    }


	function get_friends_trips($uid) {
        $key = 'friends_trips_by_uid:'.$uid;
        $trips = $this->mc->get($key);
        if($trips === false) {
            $sql = 'SELECT trips_users.tripid FROM trips_users, trips WHERE trips_users.uid = ? AND trips_users.type = "advisor" AND trips_users.tripid = trips.tripid AND trips.active = 1';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);
            $tripids = array();
            if($rows) {
                foreach($rows as $row) {
                    $tripids[] = $row['tripid'];
                }
            }
            $this->mc->set($key, $tripids);
        }
        $trips = array();
        foreach($tripids as &$tripid) {
            $trips[] = $this->get_trip_by_tripid($tripid);
        }
        return $trips;
    }
    
    //DELETE, ONLY GET USERS BY UID
	//function get_users_by_tripid($tripid, $rsvp) {
		//$key = 'users_by_tripid:'.$tripid;
	    //$uids = $this->mc->get($key);
	    //if($uids === false) {
	        //$sql = 'SELECT uid FROM trips_users WHERE tripid = ? '.
				//'AND rsvp = ?';
	        //$v = array($tripid, $rsvp);
	        //$rows = $this->mdb->select($sql, $v);
	        //$uids = array();
	        //if($rows) {
	            //foreach($rows as $row) {
	                //$uids[] = $row['uid'];
	            //}
	        //}
	        //$this->mc->set($key, $uids);
	    //}
	    //$users = array();
		//foreach($uids as &$uid) {
			//$users[] = $this->User_m->get_user_by_uid($uid);
		//}
	    //return $users;
	//}
	
	function invite_uids_by_tripid($tripid, $uids) {
        //how do I batch alter using mdb??
        foreach($uids as &$uid) {
            
            $d = array('tripid' => $tripid,
                       'uid' => $uid,
                       'rsvp' => 'awaiting',
                       );

            list($sql, $values) = $this->mdb->insert_string('trips_users', $d);
            $this->mdb->alter($sql, $values);
            //should I delete something from cache here?
        }
        return true;
    }
    
    
	function get_rsvp_by_tripid_uid($tripid, $uid) {
        $key = 'rsvp_by_tripid_uid:'.$tripid.':'.$uid;
        $rsvp = $this->mc->get($key);
        if($rsvp === false) {
            $sql = 'SELECT rsvp FROM trips_users WHERE tripid = ? AND uid = ?';
            $v = array($tripid, $uid);
            $rows = $this->mdb->select($sql, $v);
            $rsvp = $rows[0];
            $this->mc->set($key, $rsvp);
        }
        return $rsvp['rsvp'];
    }
    
    
    function get_type_by_tripid_uid($tripid, $uid) {
        $key = 'type_by_tripid_uid:'.$tripid.':'.$uid;
        $type = $this->mc->get($key);
        if($type === false) {
            $sql = 'SELECT type FROM trips_users WHERE tripid = ? AND uid = ?';
            $v = array($tripid, $uid);
            $rows = $this->mdb->select($sql, $v);
            $type = $rows[0];
            $this->mc->set($key, $rsvp);
        }
        return $type['type'];
    }
    
    
    function update_mapcenter_by_tripid($lat, $lng, $tripid) {
        $sql = 'UPDATE trips SET lat = ?, lng = ? WHERE tripid = ?';
        $v = array($lat, $lng, $tripid);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('trip_by_tripid:'.$tripid);
        return true;
    }
    
    
    function update_latlngbounds_by_tripid($sBound, $wBound, $nBound, $eBound, $tripid) {
        $sql = 'UPDATE trips SET sBound = ?, wBound = ?, nBound = ?, eBound = ? WHERE tripid = ?';
        $v = array($sBound, $wBound, $nBound, $eBound, $tripid);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('trip_by_tripid:'.$tripid);
        return true;
    }

    
    //CLEANUP AFTER THIS LINE
    ///////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////
    // [Trip] Items (Suggestions)

    function get_item_by_id($itemid) {
        $key = 'item_by_id:'.$itemid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM trip_items WHERE itemid = ?';
            $v = array($itemid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            
            $this->mc->set($key, $val);
        }
        
        $val['user'] = $this->User_m->get_user_by_uid($val['uid']);
        $val['trip'] = $this->get_trip_by_tripid($val['tripid']);
        
        return $val;
    }


    function get_items_by_tripid($tripid, $order = 'DESC') {
        $key = 'itemids_by_tripid:'.$tripid.':'.$order;
        $itemids = $this->mc->get($key);

        if($itemids === false) {
            $sql = 'SELECT itemid FROM trip_items WHERE tripid = ? '.
                    'ORDER BY created '.$order;

            $v = array($tripid);
            $rows = $this->mdb->select($sql, $v);
            $itemids = array();
            if($rows) {
                foreach($rows as $row) {
                    $itemids[] = $row['itemid'];
                }
            }
            $this->mc->set($key, $itemids);
        }

        $items = array();
        foreach($itemids as $itemid) {
            $items[] = $this->get_item_by_id($itemid);
        }
        return $items;
    }


    function format_items_as_thread($items) {
        $thread = array();
        $item_index = array();
        $recent_times = array();
        $index = 0;
        foreach($items as $k => $item) {
            if($item['replyid']) {
                $parent = &$item_index[$item['replyid']];
                $parent['replies'][] = &$items[$k];
                $recent_times[$parent['index']] = $item['created'];
            } else {
                $items[$k]['index'] = $index; 
                $index += 1;
                $items[$k]['replies'] = array();

                $recent_times[] = $item['created'];
                $thread[] = &$items[$k];
            }
            $item_index[$item['itemid']] = &$items[$k];
        }
        array_multisort($recent_times, SORT_DESC, $thread);
        return $thread;
    }


    function get_uids_in_thread($orig_item) {
        $key = 'uids_in_thread:'.$orig_item['itemid'];
        $uids = $this->mc->get($key);
        if($uids === false) {
            $sql = 'SELECT uid FROM trip_items WHERE replyid = ? '.
                'ORDER BY created ASC';
            $v = array($orig_item['itemid']);
            $rows = $this->mdb->select($sql, $v);
            $uids = array($orig_item['uid']);
            foreach($rows as $row) {
                $uids[] = $row['uid'];
            }
            $this->mc->set($key, $uids);
        }
        return $uids;
    }


    function create_item($uid, $tripid, $yelpid, $body,
                         $yelpjson, $lat, $lon,
                         $replyid, $islocation = 0) {
                             
        $d = array('uid' => $uid,
                   'tripid' => $tripid,
                   'yelpid' => $yelpid,
                   'body' => $body,
                   'yelpjson' => $yelpjson,
                   'lat' => $lat,
                   'lon' => $lon,
                   'replyid' => $replyid,
                   'islocation' => $islocation,
               );
        
        list($sql, $values) = $this->mdb->insert_string('trip_items', $d);
        $itemid = $this->mdb->alter($sql, $values);

        $this->mc->delete('item_by_id:'.$itemid);
        $this->mc->delete('itemids_by_tripid:'.$tripid);
        if($replyid) {
            $this->mc->delete('uids_in_thread:'.$replyid);
        }

        return $itemid;
    }

    //BROKEN BECAUSE I DELETED get_user_tripids
    function update_item($itemid, $status) {
        $uid = $this->User_m->get_logged_in_uid();
        $item = $this->get_item_by_id($itemid);
        if(!$uid || !$item)
            return false;

        // If it's not YOUR trip OR it's not YOUR post, die
        $user_trips = $this->get_user_tripids($uid);
        if(!in_array($item['tripid'], $user_trips) &&
            $item['uid'] != $uid) {
            return false;
        }

        $sql = 'UPDATE trip_items SET status = ? WHERE itemid = ?';
        $v = array($status, $itemid);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('item_by_id:'.$itemid);
        $this->mc->delete('itemids_by_tripid:'.$item['tripid']);
        return true;
    }
    
    //fix this, this shows all trips items from every user
    function get_trip_news_for_user($uid, $order = 'DESC', $limit = 100) {
        $key = 'get_trip_news_for_user:'.$uid.':'.$order;
        $itemids = $this->mc->get($key);

        if($itemids === false) {
            $order = strtoupper($order) == 'DESC' ? 'DESC' : 'ASC';
            $sql = 'SELECT itemid FROM trip_items '.
                    'ORDER BY created '.$order;

            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);
            $itemids = array();
            if($rows) {
                foreach($rows as $row) {
                    $itemids[] = $row['itemid'];
                }
            }
            $this->mc->set($key, $itemids);
        }

        $items = array();
        foreach($itemids as $itemid) {
            $items[] = $this->get_item_by_id($itemid);
        }
        return $items;
    }
    
}
