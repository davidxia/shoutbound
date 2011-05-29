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
        $user = $this->mc->get($key);
        if ($user === FALSE)
        {
            $sql = 'SELECT * FROM `users` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $user = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $user);
        }
        
        $this->row2obj($user);
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
    

    public function get_onboarding_trips()
    {
        $trip_ids = array();
        $sql = 'SELECT DISTINCT pt.trip_id FROM `places_trips` pt, `trips` t WHERE t.is_active = 1 AND pt.trip_id = t.id AND pt.trip_id NOT IN (SELECT trip_id FROM `trips_users` WHERE user_id = ? AND rsvp = 3)';
        $v = array($this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $trip_ids[] = (int) $row->trip_id;
        }
        
        $this->onboarding_trips = array();
        foreach ($trip_ids as $trip_id)
        {
            $trip = new Trip_m($trip_id);
            $trip->get_goers();
            $trip->get_places();
            $this->onboarding_trips[] = $trip;
        }
    }


    public function get_onboarding_places()
    {
        $place_ids = array();
        $sql = 'SELECT pt.place_id FROM `places_trips` pt WHERE pt.place_id NOT IN (SELECT pu.place_id FROM `places_users` pu WHERE pu.user_id = ? AND pu.is_following = 1)';
        $v = array($this->id);
        $rows = $this->mdb->select($sql, $v);
        foreach ($rows as $row)
        {
            $place_ids[] = (int) $row->place_id;
        }

        $this->onboarding_places = array();
        foreach ($place_ids as $place_id)
        {
            $place = new Place_m($place_id);
            $this->onboarding_places[] = $place;
        }
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

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */