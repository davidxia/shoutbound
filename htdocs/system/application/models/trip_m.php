<?php

class Trip_m extends Model {

    function get_trip_by_tripid($tripid) {
        $key = 'trip_by_tripid:'.$tripid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM tripsi WHERE tripid = ?';
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
        $this->mdb->alter($sql, $values);
    }


    function get_user_tripids($uid) {
        $key = 'tripids_by_uid:'.$uid;
        $tripids = $this->mc->get($key);
        if($tripids === false) {
            $sql = 'SELECT tripid FROM trips WHERE uid = ?';
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
        return $val;
    }


    function get_items_by_tripid($tripid) {
        $key = 'itemids_by_tripid:'.$tripid;
        $itemids = $this->mc->get($key);

        if($itemids === false) {
            $sql = 'SELECT itemid FROM trip_items WHERE tripid = ? '.
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


    function create_item($uid, $tripid, $yelpid, $title, $body, $lat, $lon, $replyid = 0) {
        $d = array('uid' => $uid,
                   'tripid' => $tripid,
                   'yelpid' => $yelpid,
                   'title' => $title,
                   'body' => $body,
                   'lat' => $lat,
                   'lon' => $lon,
                   'replyid' => $replyid,
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

        // Users can only update items within THEIR trips
        $user_trips = $this->get_user_tripids($uid);
        if(!in_array($item['tripid'], $user_trips)) {
            return false;
        }

        $sql = 'UPDATE trip_items SET status = ? WHERE itemid = ?';
        $v = array($status, $itemid);
        $this->mdb->alter($sql, $v);
        return true;
    }

}

