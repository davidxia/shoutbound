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
        if($val === false || true) {
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
        if($val === false || true) {
            $sql = 'SELECT * FROM users WHERE uid = ?';
            $v = array($uid);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }
        return $val;
    }



    ////////////////////////////////////////////////////////////
    // Creating users

    function create_user($udata) {
        list($sql, $values) = $this->mdb->insert_string('users', $udata);
        $uid = $this->mdb->alter($sql, $values);
        $udata['uid'] = $uid;
        $this->dirty_user_cache($udata);
        $this->Trip_m->create_trip($uid, 'Home',
            $udata['home_lat'], $udata['home_lon']);
        return $uid;
    }


    function add_friendship($uid, $friend_fid, $friend_name, $friend_uid = 0) {
        $d = array('uid' => $uid,
                   'friend_fid' => $friend_fid,
                   'name' => $friend_name);
        list($sql, $values) = $this->mdb->insert_string('friends', $d);
        $this->mdb->alter($sql, $values);
    }


}

