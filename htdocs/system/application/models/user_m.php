<?php

class User_m extends Model {
    
    function get_user_by_fid($fid) {
        $sql = 'SELECT * FROM users WHERE fid = ?';
        $v = array($fid);
        $rows = $this->mdb->select($sql, $v);
        return $rows[0];
    }
    
    function get_logged_in_user(){
        return array(
            'id'=>'12345',
            'name'=>'test user'
        );
    }
}
