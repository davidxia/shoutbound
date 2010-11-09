<?php

class User_m extends Model {

    ////////////////////////////////////////////////////////////
    // Logging Users in and out

    function log_in($uid) {
        set_cookie('uid', $uid);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($uid, $key);
        set_cookie('key', $key);
        set_cookie('sig', $sig);
    }


    function log_out() {
        delete_cookie('uid');
        delete_cookie('key');
        delete_cookie('sig');
    }


    function get_logged_in_uid() {
        $uid = get_cookie('uid');
        if(!$uid)
            return False;
        $key = get_cookie('key');
        $sig = get_cookie('sig');
        if($sig == $this->get_sig($uid, $key)) {
            return $uid;
        }
    }


    function get_logged_in_user() {
        $uid = $this->get_logged_in_uid();
        if($uid)
            return $this->get_user_by_uid($uid);
        return null;
    }


    function get_sig($uid, $key) {
        return md5($uid . '~nokonmyballz~' . $key);
    }

    ////////////////////////////////////////////////////////////
    // Getting users/udata

    function dirty_user_cache($udata) {
        $this->mc->delete('user_by_fid:'.$udata['fid']);
    }


    function get_user_by_fid($fid) {
        $key = 'user_by_fid:'.$fid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM users WHERE fid = ?';
            $v = array($fid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }
        return $val;
    }


    function get_user_by_uid($uid) {
        $key = 'user_by_uid:'.$uid;
        $val = $this->mc->get($key);
        if($val === false) {
            $sql = 'SELECT * FROM users WHERE uid = ?';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }
        return $val;
    }


    function get_friends_by_uid($uid) {
        $key = 'friend_uids_by_uid:'.$uid;
        $uids = $this->mc->get($key);
        if($uids === false) {
            $sql = 'SELECT friend_uid FROM friends WHERE '.
                'uid = ? AND friend_uid != 0';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);

            $uids = array();
            foreach($rows as $row)
                $uids[] = $row['friend_uid'];
            $this->mc->set($key, $uids);
        }
        $friends = array();
        foreach($uids as $uid) {
            $friends[] = $this->get_user_by_uid($uid);
        }
        return $friends;
    }


    function get_settings($uid) {
        $key = 'settings_by_uid:'.$uid;
        $settings = $this->mc->get($key);
        if($settings === false) {
            $sql = 'SELECT * FROM user_settings WHERE uid = ?';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);

            $settings = $rows[0];
            if(!$settings) {
                $settings = array('trip_suggestion' => 1,
                                  'trip_post'       => 1,
                                  'trip_reply'      => 1,
                                  'replies'         => 2,
                              );
            }

            $this->mc->set($key, $settings);
        }
        return $settings;
    }

    ////////////////////////////////////////////////////////////
    // Updating users

    function update_settings($uid, $trip_suggestion, $trip_post, $trip_reply, $replies) {
        $sql = 'INSERT INTO user_settings (uid, trip_suggestion, trip_post, trip_reply, replies) '.
            'VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
            'trip_suggestion = ?, trip_post = ?, trip_reply = ?, replies = ?';
        $v = array($uid, $trip_suggestion, $trip_post, $trip_reply, $replies,
            $trip_suggestion, $trip_post, $trip_reply, $replies);
        $this->mdb->alter($sql, $v);
        $this->mc->delete('settings_by_uid:'.$uid);
    }

    ////////////////////////////////////////////////////////////
    // Creating users

    function create_user($udata) {
        list($sql, $v) = $this->mdb->insert_string('users', $udata);
        $uid = $this->mdb->alter($sql, $v);
        $udata['uid'] = $uid;
        $this->dirty_user_cache($udata);
        /*$this->Trip_m->create_trip($uid, 'Home',
            $udata['home_lat'], $udata['home_lon']);*/

        $sql = 'UPDATE friends SET friend_uid = ? WHERE friend_fid = ?';
        $v = array($uid, $udata['fid']);
        $this->mdb->alter($sql, $v);

        return $uid;
    }


    function add_friendship($uid, $friend_fid, $friend_name) {
        $d = array('uid' => $uid,
                   'friend_fid' => $friend_fid,
                   'name' => $friend_name);
        if($friend_user = $this->get_user_by_fid($friend_fid))
            $d['friend_uid'] = $friend_user['uid'];

        list($sql, $values) = $this->mdb->insert_string('friends', $d);
        $this->mdb->alter($sql, $values);
    }


}

