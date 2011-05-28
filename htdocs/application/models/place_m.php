<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_m extends CI_Model
{
    public $id;
    public $name;
    public $admin1;
    public $country;
    public $type;
    public $lat;
    public $lng;
    public $sw_lat;
    public $sw_lng;
    public $ne_lat;
    public $ne_lng;
    

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
        $key = 'place_by_place_id:'.$id;
        $place = $this->mc->get($key);
        if ($place === FALSE)
        {
            $sql = 'SELECT * FROM `places` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $place = $rows[0];
            $this->mc->set($key, $place);
        }

        $this->row2obj($place);
    }


    public function get_num_posts()
    {
        $key = 'num_posts_by_place_id:'.$this->id;
        $num_posts = $this->mc->get($key);
        
        if ($num_posts === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `places_posts` WHERE place_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_posts = (int) $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_posts);
        }

        $this->num_posts = $num_posts;
    }


    public function row2obj($row)
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            $this->$k = $row->$k;
        }    
    }


}

/* End of file place_m.php */
/* Location: ./application/models/place_m.php */