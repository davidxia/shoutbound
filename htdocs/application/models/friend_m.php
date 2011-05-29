<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend_m extends CI_Model
{
    public $id;
    public $facebook_id;
    public $name;    

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
        $key = 'friend_by_friend_id:'.$id;
        $friend = $this->mc->get($key);
        if ($friend === FALSE)
        {
            $sql = 'SELECT * FROM `friends` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $friend = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $friend);
        }

        $this->row2obj($friend);
    }


    public function row2obj($row)
    {
        if ( ! is_null($row))
        {
            foreach (get_object_vars($this) as $k => $v)
            {
                $this->$k = $row->$k;
            }    
        }
    }


}

/* End of file friend_m.php */
/* Location: ./application/models/friend_m.php */