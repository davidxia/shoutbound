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
        $places = $this->mc->get($key);
        
        if ($places === FALSE)
        {
            $this->load->helper('places');
            $places = query_places($query);
            $this->mc->set($key, $places);
        }
        
        echo json_encode($places);        
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
        
        $place->get_num_posts()
              ->get_num_trips()
              ->get_num_followers()
              ->get_posts();
        
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
        if ( ! $this->input->post('placeId'))
        {
            return;
        }
        
        $place_id = $this->input->post('placeId');
        $follow = $this->input->post('follow');
        
        $num_affected = $this->user->edit_follow_for_place_id($place_id, $follow);        
        $new_follow = ($num_affected == 1) ? TRUE : FALSE;
        
        if ($new_follow)
        {
            $this->load->model('Activity_m');
            $a = new Activity_m();
            $a->create(array('user_id' => $this->user->id, 'activity_type' => 5, 'source_id' => $place_id));
        }

        if ($num_affected == 1 OR $num_affected == 2)
        {
            $this->mc->delete('follow_status_by_place_id_user_id:'.$place_id.':'.$this->user->id);
            $this->mc->delete('num_followers_by_place_id:'.$place_id);
            $this->mc->delete('follower_ids_by_place_id:'.$place_id);
            
            json_success(array('type' => 'place', 'id' => $place_id, 'follow' => $follow));
        }
        else
        {
            json_error();
        }
    }
    
    
    public function ajax_edit_fut_place()
    {
        $place_id = $this->input->post('placeId');
        $is_future = $this->input->post('isFuture');
        
        if ($this->user->edit_future_place_by_place_id($place_id, $is_future))
        {
            $this->user->edit_follow_for_place_id($place_id, 1);
            json_success();
        }
        else
        {
            json_error();
        }
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
        
        $data = array('str' => $info);
        $this->load->view('blank', $data);
    }
    
    
    public function dbpedia_query()
    {
        $this->load->view('places/dbpedia_query');
    }
    
      
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */