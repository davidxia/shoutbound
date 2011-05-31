<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
        else
        {
            redirect('/');
        }
		}
		
		
		public function index()
		{
        if ( ! $this->user->is_onboarded)
        {
            redirect(site_url('signup/dream'));
        }
        
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        $this->user->get_following_trips();
        $this->user->get_num_rsvp_yes_trips();
        $this->user->get_num_posts();
        $this->user->get_num_following_users();
        $this->user->get_num_following_trips();
        $this->user->get_num_following_places();
        $this->user->get_num_followers();
        
        $this->user->get_news_feed_items();
        
        $data = array(
            'user' => $this->user,
        );
                          
        $this->load->view('home/index', $data);
		}
	
    
    public function trail()
    {
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('home/trail', $data);
    }
    
    
    public function ajax_delete_activity()
    {
        $a = new Activity_m($this->input->post('activityId'));
        if ($a->user_id == $this->user->id AND $a->set_active(0) == 1)
        {
            json_success();
        }
        else
        {
            json_error('something broke, tell David');
        }
    }

    
    
/*
    public function simplegeo_test()
    {
        $this->load->view('simplegeo_test');
    }
*/
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */