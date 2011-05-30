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
    
    
    public function set_active($is_active = 1)
    {
        $sql = 'UPDATE `activities` SET is_active = ? WHERE id = ?';
        $v = array($is_active, $this->id);
        $r = $this->mdb->alter($sql, $v);
        return $r['num_affected'];
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

/* End of file activity_m.php */
/* Location: ./application/models/activity_m.php */