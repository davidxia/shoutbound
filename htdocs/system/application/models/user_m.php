<?php

class User_m extends Model {
    
    function get_user_by_fid($fid) {
        $sql = 'SELECT * FROM users WHERE fid = ?';
        $v = array($fid);
        $rows = $this->mdb->select($sql, $v);
        return $rows[0];
    }
}
