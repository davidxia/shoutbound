<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity_m extends CI_Model
{
    public $id;
    public $user_id;
    public $activity_type;
    public $source_id;
    public $parent_id;
    public $parent_type;
    private $is_active;
    public $timestamp;
    

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
        $key = 'activity_by_activity_id:'.$id;
        $activity = $this->mc->get($key);
        if ($activity === FALSE)
        {
            $sql = 'SELECT * FROM `activities` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $activity = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $activity);
        }

        $this->row2obj($activity);
        return $this;
    }
    
    
    public function create($params)
    {
        if ( ! is_array($params))
        {
           return FALSE;
        }
        
        $user_id = (isset($params['user_id'])) ? $params['user_id'] : NULL;
        $activity_type = (isset($params['activity_type'])) ? $params['activity_type'] : NULL;
        $source_id = (isset($params['source_id'])) ? $params['source_id'] : NULL;
        $parent_id = (isset($params['parent_id'])) ? $params['parent_id'] : NULL;
        $parent_type = (isset($params['parent_type'])) ? $params['parent_type'] : NULL;
        $timestamp = time() - 72;
        
        if (!isset($user_id) OR !isset($activity_type) OR !isset($source_id))
        {
            return FALSE;
        }
                
        $sql = 'INSERT INTO `activities` (`user_id`, `activity_type`, `source_id`, `parent_id`, `parent_type`, `timestamp`) VALUES (?, ?, ?, ?, ?, ?)';
        $values = array($user_id, $activity_type, $source_id, $parent_id, $parent_type, $timestamp);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->id = $r['last_insert_id'];
            $this->user_id = $user_id;
            $this->activity_type = $activity_type;
            $this->source_id = $source_id;
            $this->parent_id = $parent_id;
            $this->parent_type = $parent_type;
            $this->timestamp = $timestamp;
            return TRUE;
        }
    }
    
    
    public function get_source()
    {
        switch ($this->activity_type)
        {
            case 3:
                $u = new User_m($this->source_id);
                $this->following = $u;
                break;
            case 1:
            case 4:
                $t = new Trip_m($this->source_id);
                $this->trip = $t;
                break;
            case 2:
            case 6:
                $p = new Post_m($this->source_id);
                $p->convert_nl();
                $this->post = $p;
                break;
            case 7:
                break;
            case 8:
                $u = new User_m($this->source_id);
                $this->follower = $u;
                break;
            case 9:
                $activity->message = ' changed his bio.';
                break;
            case 5:
            case 10:
                $p = new Place_m($this->source_id);
                $this->place = $p;
                break;
        }
        
        return $this;
    }
    
    
    public function get_parent()
    {
        switch ($this->parent_type)
        {
            case 1:
                $p = new Place_m($this->parent_id);
                $this->place = $p;
                break;
            case 2:
                $t = new Trip_m($this->parent_id);
                $this->trip = $t;
                break;
            case 4:
                $p = new Post_m($this->parent_id);
                $p->get_author();
                $this->post = $p;
                break;
        }

        return $this;
    }
    
    
/*
    public function set_active($is_active = 1)
    {
        $sql = 'UPDATE `activities` SET is_active = ? WHERE id = ?';
        $v = array($is_active, $this->id);
        $r = $this->mdb->alter($sql, $v);
        return $r['num_affected'];
    }
*/


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

/* End of file activity_m.php */
/* Location: ./application/models/activity_m.php */