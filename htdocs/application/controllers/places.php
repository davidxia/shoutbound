<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        if ($u->get_logged_in_status())
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
        
        $p = new Place($id);
        if ( ! $p->id)
        {
            custom_404();
            return;
        }
        
        $p->get_num_posts();
        $p->get_num_trips();
        $p->get_num_followers();
        $p->get_posts();
        
        if (isset($this->user->id))
        {
            $p->get_follow_status_by_user_id($this->user->id);
        }
        $user = (isset($this->user->id)) ? $this->user->stored : NULL;
        
        $data = array(
            'user' => $user,
            'place' => $p->stored,
        );
        $this->load->view('places/index', $data);
    }
    
    
    public function trips($place_id = FALSE)
    {
        if ( ! $place_id)
        {
            redirect('/');
        }
        
        $p = new Place($place_id);
        $p->get_trips();
        $data = array(
            'place' => $p->stored,
        );
        
        $this->load->view('places/trips', $data);
    }
    
    
    public function followers($place_id = FALSE)
    {
        if ( ! $place_id)
        {
            redirect('/');
        }

        $p = new Place($place_id);
        $user_id = ($this->user) ? $this->user->id : NULL;
        $p->get_followers($user_id);
        
        $data = array(
            'place' => $p->stored,
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
    
      
    public function mytest()
    {
        $p = new Place(4);
        $was_cached = $p->get_follow_status_by_user_id(1);
        print_r($p->stored);
    }    
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */