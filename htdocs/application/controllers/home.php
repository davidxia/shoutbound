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
        $t = new Trip();
        
        // get active trips for which user is a planner or creator and rsvp is yes
        $temp = $this->user->get_trips();
        $trips = array();
        foreach ($temp as &$trip)
        {
            $trip->stored->users = $trip->get_goers();
            $trip->stored->places = $trip->get_places();
            $trips[] = $trip->stored;
        }

        // get active trips for which user is an advisor
        $temp = $this->user->get_advising_trips();
        $advising_trips = array();
        foreach ($temp as &$trip)
        {
            $trip->stored->users = $trip->get_goers();
            $trip->stored->places = $trip->get_places();
            $advising_trips[] = $trip->stored;
        }
        
        // get suggestions for both user's trips and her friends trips
        $news_feed_items = $this->user->get_news_feed_items();
        
        
        $view_data = array(
            'user' => $this->user->stored,
            'trips' => $trips,
            'advising_trips' => $advising_trips,
            'news_feed_items' => $news_feed_items,
        );
                          
        $this->load->view('home', $view_data);
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