<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u;
        }
		}
		

    public function ajax_autocomplete()
    {
        $this->load->library('Mc');

        $query = $this->input->post('query');
        $key = 'places_by_query:'.$query;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $p = new Place();
            $p->ilike('name', $query, 'after')->order_by('area_rank', 'desc')->order_by('pop_rank', 'desc')->limit(10)->get();
            
            $val = array();
            foreach ($p as $place)
            {
                $name = $place->name;
                if ($place->admin1)
                {
                    $name .= ', '. $place->admin1;
                }
                if ($place->country)
                {
                    $name .= ', '. $place->admin1;
                }
                $val[$place->id] = $name;
            }

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
        $this->load->view('templates/autocomplete', $data);
    }
        
    
    public function index($id = NULL)
    {
        if ( ! $id)
        {
            custom_404();
            return;
        }
        
        $gp = new Place($id);
        if ( ! $gp->id)
        {
            custom_404();
            return;
        }
        
        $gp->get_num_posts();
        $gp->get_num_trips();
        $gp->get_num_followers();
        $gp->get_posts();
        
        if (isset($this->user->id))
        {
            $this->user->get_follow_status_by_place_id($id);
        }
        $user = (isset($this->user->id)) ? $this->user->stored : NULL;
        
        $data = array(
            'user' => $user,
            'place' => $gp->stored,
        );
        $this->load->view('places/index', $data);
        //print_r($this->user->stored);
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
        $p->get_followers();
        $data = array(
            'place' => $p->stored,
        );

        $this->load->view('places/followers', $data);
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
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */