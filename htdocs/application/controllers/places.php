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
    
    
    public function mytest()
    {
        $this->load->library('Mc');
        
        $key = 'places_by_query:'.'budapest';
        //$val = array('jakarta', 'jabberwokky');
        //print_r($val);
        
        //$this->mc->set($key, $val);
        //$this->mc->delete($key);
        $val = $this->mc->get($key);
        
        print_r($val);
    }
    
    
    public function index($id = FALSE)
    {
        if ( ! $id)
        {
            custom_404();
            return;
        }
        
        $p = new Place($id);
        //print_r($p->stored);
        
        $gp = new Geoplanet_place(4);
        $gp->get_num_posts();
        $gp->get_num_trips();
        $gp->get_num_followers();
        $gp->get_posts();
        //print_r($gp->stored);
        //print_r($posts);
        
        $this->user->get_follow_status_by_place_id(4);
        
        
        
        $user = (isset($this->user->id)) ? $this->user->stored : NULL;
        
        $data = array(
            'user' => $user,
            'place' => $gp->stored,
        );
        $this->load->view('place', $data);
        
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