<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends CI_Model
{
    public $id;
    public $name;
    public $bio;
    public $url;
    public $profile_pic;
    

    function __construct($id = NULL)
    {
        parent::__construct();
        if (is_int($id))
        {
            $this->get_by_id($id);
        }
    }
    
    public function get_by_id($id)
    {
        $key = 'user_by_user_id:'.$id;
        $val = $this->mc->get($key);
        if ($val === FALSE)
        {
            $sql = 'SELECT * FROM `users` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $val = $rows[0];
            $this->mc->set($key, $val);
        }
        
        $this->row2obj($val);
    }


    public function get_follow_status_by_user_id($user_id)
    {
        $key = 'follow_status_by_user_id:'.$this->id.':'.$user_id;
        $status = $this->mc->get($key);
        
        if ($status === FALSE)
        {
            $sql = 'SELECT is_following FROM `related_users_users` WHERE user_id = ? AND related_user_id = ?';
            $v = array($this->id, $user_id);
            $rows = $this->mdb->select($sql, $v);
            $status = (isset($rows[0])) ? (int) $rows[0]->is_following : 0;
            $this->mc->set($key, $status);
        }
        
        $this->is_following = $status;
    }

    public function row2obj($row)
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            $this->$k = $row->$k;
        }    
    }


}

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */