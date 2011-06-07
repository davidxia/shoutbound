<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}


    public function ajax_autocomplete()
    {
        $query = $this->input->post('query');
        $key = 'user_ids_by_query:'.$query;
        $user_ids = $this->mc->get($key);
        if ($user_ids === FALSE)
        {
            $user_ids = array();
            $sql = 'SELECT id FROM `users` WHERE name LIKE "'.$query.'%" AND is_active = 1 LIMIT 5';
            $rows = $this->mdb->select($sql);
            foreach ($rows as $row)
            {
                $user_ids[] = $row->id;
            }
            $this->mc->set($key, $user_ids);
        }
        $user = new User_m();
        $users = array();
        foreach ($user_ids as $user_id)
        {
            $user->get_by_id($user_id);
            $users[] = $user;
        }

        $trips = array();

        $key = 'places_by_query:'.$query;
        $places = $this->mc->get($key);
        
        if ($places === FALSE)
        {
            $this->load->helper('places');
            $places = query_places($query);
            $this->mc->set($key, $places);
        }
        
        echo json_encode(array('users' => $users, 'trips' => $trips, 'places' => $places));
    }

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */