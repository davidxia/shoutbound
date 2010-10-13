<?php

class User_m extends Model {
    
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


    function get_logged_in_user(){
        return array(
            'id'=>'12345',
            'name'=>'test user'
        );
    }
    
    
}
