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
        return $val;
    }


    function create_trip($uid, $name, $lat, $lon) {
        $d = array('uid' => $uid,
                   'name' => $name,
                   'lat'  => $lat,
                   'lon'  => $lon,
               );
        list($sql, $values) = $this->mdb->insert_string('trips', $d);
        $this->mc->delete('tripids_by_uid:'.$uid);
        $tripid = $this->mdb->alter($sql, $values);
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
            
            //nan - ummz I need names!
            $val['user'] = $this->User_m->get_user_by_uid($val['uid']);
            
            $this->mc->set($key, $val);
        }
        
        return $val;
    }


    function get_items_by_tripid($tripid) {
        $key = 'itemids_by_tripid:'.$tripid;
        $itemids = $this->mc->get($key);

        if($itemids === false) {
            $sql = 'SELECT itemid FROM trip_items WHERE tripid = ? '.
                'AND (status = "pending" OR status = "approved") '.
                'ORDER BY created DESC';

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


    function get_thread_by_tripid($tripid) {
        $items = $this->get_items_by_tripid($tripid);

        $thread = array();
        $post_index = array();
        foreach($items as $k => $item) {
            if($item['replyid']) {
                $post_index[$item['replyid']]['replies'][] = &$items[$k];
            } else {
                $thread[] = &$items[$k];
            }
            $post_index[$item['postid']] = &$items[$k];
        }
        return $thread;

    }


    function create_item($uid, $tripid, $yelpid, $title, $body,
                         $yelpjson, $lat, $lon, $replyid = 0, $islocation = true) {
        $d = array('uid' => $uid,
                   'tripid' => $tripid,
                   'yelpid' => $yelpid,
                   'title' => $title,
                   'body' => $body,
                   'yelpjson' => $yelpjson,
                   'lat' => $lat,
                   'lon' => $lon,
                   'replyid' => $replyid,
                   'islocation' => $islocation
               );
        list($sql, $values) = $this->mdb->insert_string('trip_items', $d);
        $itemid = $this->mdb->alter($sql, $values);

        $this->mc->delete('item_by_id:'.$itemid);
        $this->mc->delete('itemids_by_tripid:'.$tripid);

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


}

