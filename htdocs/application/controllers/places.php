<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
		}
						
				
    public function ajax_autocomplete()
    {
        $query = $this->input->post('query');
        $key = 'places_by_query:'.$query;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->load->helper('places');
            $val = query_places($query);
            $this->mc->set($key, $val);
            //$was_cached = 0;
        }
/*
        else
        {
            $was_cached = 1;
        }
*/

        $data = array(
            'places' => $val,
            'was_cached' => $was_cached,
        );
        
        if ($this->input->post('isPost'))
        {
            $this->load->view('templates/omnibar_autocomplete', $data);
        }
        elseif ($this->input->post('isSettings'))
        {
            $this->load->view('templates/settings_autocomplete', $data);
        }
        else
        {
            $this->load->view('templates/autocomplete', $data);
        }
        
    }
        
    
    public function index($id = NULL)
    {
        if ( ! $id)
        {
            custom_404();
            return;
        }
        
        $place = new Place_m($id);
        if ( ! $place->id)
        {
            custom_404();
            return;
        }
        
        $place->get_num_posts()->get_num_trips()->get_num_followers()->get_posts();
        
        if ($this->user)
        {
            $place->get_follow_status_by_user_id($this->user->id);
        }
        
        $data = array(
            'user' => $this->user,
            'place' => $place,
        );
        $this->load->view('places/index', $data);
    }
    
    
    public function trips($place_id = NULL)
    {
        $place = new Place_m($place_id);
        $place->get_trips();
        $data = array(
            'place' => $place,
        );
        
        $this->load->view('places/trips', $data);
    }
    
    
    public function followers($place_id = NULL)
    {
        $place = new Place_m($place_id);
        $user_id = ($this->user) ? $this->user->id : NULL;
        $place->get_followers($user_id);
        
        $data = array(
            'user' => $this->user,
            'place' => $place,
        );

        $this->load->view('places/followers', $data);
    }
    
    
    public function related_places($place_id = NULL)
    {
        $place = new Place_m($place_id);
        $user_id = ($this->user) ? $this->user->id : NULL;
        $place->get_related_places($user_id);

        $data = array(
            'place' => $place,
        );

        $this->load->view('places/related_places', $data);
    }


    public function ajax_set_follow()
    {
        $place_id = $this->input->post('placeId');
        $follow = $this->input->post('follow');
        
        $place = new Place_m($place_id);
        $num_affected = $place->set_follow_by_user_id($this->user->id, $follow);
        
        $new_follow = ($num_affected == 1) ? TRUE : FALSE;
        
        if ($new_follow)
        {
            $this->load->helper('activity');
            save_activity($this->user->id, 5, $place_id, NULL, NULL, time()-72);
        }

        if ($num_affected == 1 OR $num_affected == 2)
        {
            $this->mc->delete('follow_status_by_place_id_user_id:'.$place_id.':'.$this->user->id);
            $this->mc->delete('num_followers_by_place_id:'.$place_id);
            $this->mc->delete('follower_ids_by_place_id:'.$place_id);
            
            $data = array('str' => json_success(array('type' => 'place', 'id' => $place_id, 'follow' => $follow)));
        }
        else
        {
            $data = array('str' => json_error());
        }
        $this->load->view('blank', $data);
    }
    
    
    public function ajax_rem_fut_place()
    {
        $place_id = $this->input->post('placeId');
        $place = new Place_m($place_id);
        if ($place->rem_fut_place_by_user_id($this->user->id, 0))
        {
            $data = array('str' => json_success());
        }
        else
        {
            $data = array('str' => json_error());
        }
        $this->load->view('blank', $data);
    }


    public function ajax_dbpedia_query()
    {   
        $query = urlencode($this->input->post('query'));
        $alt_query = urlencode($this->input->post('altQuery'));
        
        $query_timeout = 5;
        $handle = popen('/usr/bin/python '.__DIR__.'/../helpers/dbpedia_query.py '.$query.' '.$alt_query, 'r');
        stream_set_blocking($handle, TRUE);
        stream_set_timeout($handle, $query_timeout);
        
        $info = fread($handle, 4096);
        pclose($handle);
        $this->output->set_output($info);
    }
    
    
    public function dbpedia_query()
    {
        $this->load->view('places/dbpedia_query');
    }
    
      
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */