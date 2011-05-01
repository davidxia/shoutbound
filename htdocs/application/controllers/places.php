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
            $p->ilike('ascii_name', $query, 'after')->limit(10)->get();
            
            $val = array();
            foreach ($p as $place)
            {
                $val[$place->id] = $place->ascii_name;
            }

            $this->mc->set($key, $val);

            json_success(array(
                'places' => $val,
                'cached' => 0
            ));
        }
        else
        {
            json_success(array(
                'places' => $val,
                'cached' => 1
            ));
        }
    }
        
    
    public function index($id = FALSE)
    {
        if ( ! $id)
        {
            custom_404();
            return;
        }
        
        $gp = new Geoplanet_place($id);
        if ( ! $gp->id)
        {
            custom_404();
            return;
        }
        
        $gp->get_num_posts();
        $gp->get_num_trips();
        $gp->get_num_followers();
        $gp->get_posts();
        
        $this->user->get_follow_status_by_place_id(4);
        $user = (isset($this->user->id)) ? $this->user->stored : NULL;
        
        $data = array(
            'user' => $user,
            'place' => $gp->stored,
        );
        $this->load->view('place/index', $data);
        
    }
    
    
    public function trips($place_id = FALSE)
    {
        if ( ! $place_id)
        {
            redirect('/');
        }
        
        $p = new Geoplanet_place($place_id);
        $p->get_trips();
        $data = array(
            'place' => $p->stored,
        );
        
        $this->load->view('place/trips', $data);
    }
    
    
    public function followers($place_id = FALSE)
    {
        if ( ! $place_id)
        {
            redirect('/');
        }

        $p = new Geoplanet_place($place_id);
        $p->get_followers();
        $data = array(
            'place' => $p->stored,
        );

        $this->load->view('place/followers', $data);
    }
    
    
    public function ajax_edit_follow()
    {
        $p = new Geoplanet_place($this->input->post('placeId'));
        if ($p->save($this->user))
        {
            $p->set_join_field($this->user, 'is_following', $this->input->post('follow'));
            echo 1;        
        }
        else
        {
            echo 0;
        }
    }
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */