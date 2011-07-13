<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venue_m extends CI_Model
{
    public $id;
    public $name;
    public $country;
    public $admin1;
    public $admin2;
    public $address;
    public $postal;
    public $lat;
    public $lng;
    public $type;
    public $url;
    public $phone;
    public $description;
    
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
        $key = 'venue_by_venue_id:'.$id;
        $venue = $this->mc->get($key);
        if ($venue === FALSE)
        {
            $sql = 'SELECT * FROM `venues` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $venue = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $venue);
        }
        
        $this->row2obj($venue);
        return $this;
    }
    
    
    public function get_photos()
    {
        $key = 'photo_ids_by_venue_id:'.$this->id;
        $photo_ids = $this->mc->get($key);
        if ($photo_ids === FALSE)
        {
            $photo_ids = array();
            $sql = 'SELECT `id` FROM `photos` WHERE `venue_id`=? AND `is_active`=1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $photo_ids[] = $row->id;
            }
            $this->mc->set($key, $photo_ids);
        }
        
        $this->photos = array();
        $this->load->model('Photo_m');
        foreach ($photo_ids as $photo_id)
        {
            $photo = new Photo_m($photo_id);
            $this->photos[] = $photo;
        }
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
            if ( ! in_array($k, array('id', 'name', 'country', 'admin1', 'admin2', 'address', 'postal', 'lat', 'lng', 'type', 'url', 'phone', 'description')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file venue_m.php */
/* Location: ./application/models/venue_m.php */