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
        
        // get pending friend requests
        // get array of friends relations to the user
        $this->user->user->get();
        $rels_to = array();
        foreach ($this->user->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
        }
        // compare with array of friend relations from the user
        // TODO: is there a better way of doing this? like with a 'where' clause in one datamapper call?
        $this->user->related_user->get();
        $rels_from = array();
        foreach ($this->user->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
        }
        $num_friend_requests = count(array_diff($rels_to, $rels_from));

        
        $view_data = array(
            'user' => $this->user->stored,
            'trips' => $trips,
            'advising_trips' => $advising_trips,
            'news_feed_items' => $news_feed_items,
            'num_friend_requests' => $num_friend_requests,
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