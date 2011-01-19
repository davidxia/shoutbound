<?php

class Trip_m extends Model {

    function get_trip_by_tripid($tripid) {
        $key = 'trip_by_tripid:'.$tripid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM trips WHERE tripid = ?';
            $v = array($tripid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }
        
        //nan - this is a temporary thing
        $val['user'] = $this->User_m->get_user_by_uid($val['uid']);
        
        return $val;
    }


    function create_trip($uid, $name, $lat, $lon) {
        $d = array('uid' => $uid,
                   'name' => $name,
                   'lat'  => $lat,
                   'lon'  => $lon,
               );
        list($sql, $values) = $this->mdb->insert_string('trips', $d);
        $tripid = $this->mdb->alter($sql, $values);
        $this->mc->delete('tripids_by_uid:'.$uid);
        $this->mc->delete('trip_by_tripid:'.$tripid);
        return $tripid;
    }


    function get_user_tripids($uid) {
        $key = 'tripids_by_uid:'.$uid;
        $tripids = $this->mc->get($key);
        if($tripids === false) {
            $sql = 'SELECT tripid FROM trips WHERE uid = ? AND active = ?';
            $v = array($uid, 1);
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

    function get_user_trips($uid) {
        $key = 'trips_by_uid:'.$uid;
        $trips = $this->mc->get($key);
        if($trips === false) {
            $sql = 'SELECT * FROM trips WHERE uid = ? AND active = ?';
            $v = array($uid, 1);
            $rows = $this->mdb->select($sql, $v);
            
            $trips = $rows;
            $this->mc->set($key, $rows);
        }
        return $trips;
    }

    function delete_trip($tripid) {
        $trip = get_trip_by_tripid($tripid);
        if(!$trip)
            return false;
        if($trip['uid'] != $this->User_m->get_logged_in_uid())
            return false;

        $sql = 'UPDATE trips SET active = ? WHERE tripid = ?';
        $v = array(0, $tripid);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('tripids_by_uid:'.$trip['uid']);
        $this->mc->delete('trip_by_tripid:'.$tripid);
        return true;
    }

	function get_users_by_tripid($tripid) {
		$key = 'users_by_tripid:'.$tripid;
	    $uids = $this->mc->get($key);
	    if($uids === false) {
	        $sql = 'SELECT uid FROM trips_users WHERE tripid = ? ';
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
	    $users = array();
		foreach($uids as &$uid) {
			$users[] = $this->User_m->get_user_by_uid($uid);
		}
	    return $users;
	}
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
            $order = strtoupper($order) == 'DESC' ? 'DESC' : 'ASC';
            $sql = 'SELECT itemid FROM trip_items WHERE tripid = ? '.
                'AND (status = "pending" OR status = "approved") '.
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


    function create_item($uid, $tripid, $yelpid, $title, $body,
                         $yelpjson, $lat, $lon, $trip_owner,
                         $replyid = 0, $islocation = true) {
                             
        $d = array('uid' => $uid,
                   'tripid' => $tripid,
                   'yelpid' => $yelpid,
                   'title' => $title,
                   'body' => $body,
                   'yelpjson' => $yelpjson,
                   'lat' => $lat,
                   'lon' => $lon,
                   'replyid' => $replyid,
                   'islocation' => $islocation,
                   'tripowner' => $trip_owner,
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
    
    function get_trip_news_for_user($uid, $order = 'DESC', $limit = 100) {
        $key = 'get_trip_news_for_user:'.$uid.':'.$order;
        $itemids = $this->mc->get($key);

        if($itemids === false) {
            $order = strtoupper($order) == 'DESC' ? 'DESC' : 'ASC';
            $sql = 'SELECT itemid FROM trip_items WHERE tripowner = ? '.
                'AND (status = "pending" OR status = "approved") '.
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

