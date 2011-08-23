<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_m extends CI_Model
{
    public $id;
    public $venue_id;
    public $name;
    public $caption;
    
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
        $key = 'photo_by_photo_id:'.$id;
        $photo = $this->mc->get($key);
        if ($photo === FALSE)
        {
            $sql = 'SELECT * FROM `photos` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $photo = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $photo);
        }
        
        $this->row2obj($photo);
        return $this;
    }
        

    private function row2obj($row)
    {
        if ( ! is_null($row))
        {
            $this->reset_properties();
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
    
    
    private function reset_properties()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            if ( ! in_array($k, array('id', 'venue_id', 'name', 'caption')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file photo_m.php */
/* Location: ./application/models/photo_m.php */