<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}


    public function ajax_autocomplete()
    {
        $results = array();
        $query = $this->input->post('query');
        
        
        $key = 'user_ids_by_query:'.$query;
        $user_ids = $this->mc->get($key);
        if ($user_ids === FALSE)
        {
            $user_ids = array();
            $sql = 'SELECT id FROM `users` WHERE name LIKE "'.$query.'%" AND is_active = 1 LIMIT 3';
            $rows = $this->mdb->select($sql);
            foreach ($rows as $row)
            {
                $user_ids[] = $row->id;
            }
            $this->mc->set($key, $user_ids);
        }
        $user = new User_m();
        foreach ($user_ids as $user_id)
        {
            $user->get_by_id($user_id);
            $user->type = 'user';
            $results[] = $user;
        }
        

        $key = 'trip_ids_by_query:'.$query;
        $trip_ids = $this->mc->get($key);
        if ($trip_ids === FALSE)
        {
            $trip_ids = array();
            $sql = 'SELECT id FROM `trips` WHERE name LIKE "'.$query.'%" AND is_active = 1 LIMIT 3';
            $rows = $this->mdb->select($sql);
            foreach ($rows as $row)
            {
                $trip_ids[] = $row->id;
            }
            $this->mc->set($key, $trip_ids);
        }
        $trip = new Trip_m();
        foreach ($trip_ids as $trip_id)
        {
            $trip->get_by_id($trip_id);
            $trip->type = 'trip';
            $results[] = $trip;
        }
        

        $key = 'places_by_query:'.$query;
        $places = $this->mc->get($key);
        if ($places === FALSE)
        {
            $this->load->helper('places');
            $places = query_places($query);
            $this->mc->set($key, $places);
        }
        $places = array_slice($places, 0, 5);
        foreach ($places as $place)
        {
            $place['type'] = 'place';
            $results[] = $place;
        }
        
        //echo json_encode(array('users' => $users, 'trips' => $trips, 'places' => $places));
        echo json_encode(array('results' => $results));
    }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */