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
            redirect('signup/dream');
        }
        
        $this->user
            ->get_rsvp_yes_trips()
            ->get_rsvp_awaiting_trips()
            ->get_following_trips()
            ->get_num_rsvp_yes_trips()
            ->get_num_posts()
            ->get_num_following_users()
            ->get_num_following_trips()
            ->get_num_following_places()
            ->get_num_followers()
            ->get_news_feed_items()
            ->get_current_place();
        
        $data = array(
            'user' => $this->user,
        );
        
        //echo '<pre>';print_r($this->user); echo '</pre>';
                          
        $this->load->view('home/index', $data);
		}
	
    
    public function trips()
    {
        $this->user
            ->get_rsvp_yes_trips()
            ->get_rsvp_awaiting_trips()
            ->get_rsvp_no_trips();
        
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('home/trips', $data);
    }
    
    
    public function ajax_delete_activity()
    {
        $this->load->model('Activity_m');
        $a = new Activity_m($this->input->post('activityId'));
        if ($a->user_id == $this->user->id AND $a->set_active_by_user_id($this->user->id, 0) == 1)
        {
            $data = array('str' => json_success());
        }
        else
        {
            $data = array('str' => json_error());
        }
        
        $this->load->view('blank', $data);
    }
    
    
/*
    public function mytest()
    {
        $this->load->model('Setting_m');
        $s = new Setting_m();
        $ss = $s->get_all_settings();
		    $str = '<pre>'.print_r($s,true).print_r($ss,true).'</pre>';
		    $data = array('str' => $str);
		    $this->load->view('blank', $data);
    }
*/

/*
    public function simplegeo_test()
    {
        $this->load->view('simplegeo_test');
    }
*/
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */