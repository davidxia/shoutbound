<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend_m extends CI_Model
{
    public $id;
    public $facebook_id;
    public $twitter_id;
    public $name;    

    function __construct($id = NULL)
    {
        parent::__construct();
        if (is_numeric($id))
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


    public function get_by_facebook_id($facebook_id)
    {
        $key = 'friend_by_facebook_id:'.$facebook_id;
        $this->mc->delete($key);
        $friend = $this->mc->get($key);
        
        if ($friend === FALSE)
        {
            $sql = 'SELECT * FROM `friends` WHERE facebook_id = ?';
            $v = array($facebook_id);
            $rows = $this->mdb->select($sql, $v);
            $friend = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $friend);
        }

        $this->row2obj($friend);
    }
        
    
    public function create($params)
    {
        if ( ! is_array($params))
        {
           return FALSE;
        }
        
        $facebook_id = (isset($params['facebook_id'])) ? $params['facebook_id'] : NULL;
        $twitter_id = (isset($params['twitter_id'])) ? $params['twitter_id'] : NULL;
        $name = (isset($params['name'])) ? $params['name'] : NULL;
        
        if (!isset($name) OR (!isset($facebook_id) AND !isset($twitter_id)))
        {
            return FALSE;
        }
        
        $sql = 'INSERT INTO `friends` (`facebook_id`, `twitter_id`, `name`) VALUES (?, ?, ?)';
        $values = array($facebook_id, $twitter_id, $name);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->id = $r['last_insert_id'];
            $this->facebook_id = $facebook_id;
            $this->twitter_id = $twitter_id;
            $this->name = $name;
            return TRUE;
        }
    }


    private function row2obj($row)
    {
        if ( ! is_null($row))
        {
            foreach (get_object_vars($this) as $k => $v)
            {
                $this->$k = $row->$k;
            }    
        }
        else
        {
            $this->clear();
        }
    }


    private function clear()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            $this->$k = NULL;
        }
    }
}

/* End of file friend_m.php */
/* Location: ./application/models/friend_m.php */