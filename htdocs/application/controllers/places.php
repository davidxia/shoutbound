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
		
		
		public function mytest()
		{
		    $p = new Post_m(2);
		    $p->get_likes();
		    echo '<pre>';var_dump($p);echo '</pre>';
		    $a = count(array_keys($p->likes, 1));
		    var_dump($a);
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
            $was_cached = 0;
        }
        else
        {
            $was_cached = 1;
        }
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
    
    
    public function related_places($place_id = FALSE)
    {
        $p = new Place($place_id);
        $user_id = ($this->user) ? $this->user->id : NULL;
        $p->get_related_places($user_id);

        $data = array(
            'place' => $p->stored,
        );

        $this->load->view('places/related_places', $data);
    }


    public function ajax_edit_follow()
    {
        $place_id = $this->input->post('placeId');
        $follow = $this->input->post('follow');
        
        $p = new Place($place_id);
        $p->user->include_join_fields()->where('user_id', $this->user->id)->get();
        $new_follow = (isset($p->user->join_is_following)) ? FALSE : TRUE;
        
        if ($p->save($this->user))
        {
            $p->set_join_field($this->user, 'is_following', $follow);
            $this->mc->delete('follow_status_by_placeid_userid:'.$place_id.':'.$this->user->id);
            $this->mc->delete('num_followers_by_place_id:'.$place_id);
            $this->mc->delete('followers_by_place_id:'.$place_id);
            json_success(array('type' => 'place', 'id' => $place_id, 'follow' => $follow));
        }
        else
        {
            json_error('something broken, tell David');
        }
        
        if ($new_follow)
        {
            $this->load->helper('activity');
            save_activity($this->user->id, 5, $p->id, NULL, NULL, time()-72);
        }
    }
    
    
    public function ajax_del_fut_place()
    {
        $place_id = $this->input->post('placeId');
        $this->user->place->where('id', $place_id)->get();
        $this->user->place->set_join_field($this->user, 'is_future', 0);
        $this->output->set_output(1);
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
        echo $info;
    }
    
    
    public function dbpedia_query()
    {
        $this->load->view('places/dbpedia_query');
    }
    
      
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */