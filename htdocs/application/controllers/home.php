<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
        else
        {
            redirect('/');
        }
		}
	

    function index()
    {
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        $this->user->get_following_trips();
        $this->user->get_num_rsvp_yes_trips();
        $this->user->get_num_posts();
        $this->user->get_num_following();
        $this->user->get_num_following_trips();
        $this->user->get_num_followers();
        
        $t = new Trip();        
        // get suggestions for both user's trips and her friends trips
        $news_feed_items = $this->user->get_news_feed_items();
        
        $view_data = array(
            'user' => $this->user->stored,
            'news_feed_items' => $news_feed_items,
        );
                          
        $this->load->view('home/index', $view_data);
        //print_r($news_feed_items);
    }
        
    
    public function trail()
    {
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        
        $data = array(
            'user' => $this->user->stored,
        );
        $this->load->view('home/trail', $data);
    }
            
    
    function fb_request_form()
    {
        $this->load->view('fb_request_form');
    }
    
    
    function simplegeo_test()
    {
        $this->load->view('simplegeo_test');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */