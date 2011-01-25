<?php

class Home extends Controller {
    
    function Home()
	{
		parent::Controller();
		
		//authentication
        $this->user = $this->User_m->get_logged_in_user();
        if(!$this->user) {
            redirect('/');
		}
		
		//TODO: maybe some friend detection here
	}

    function index() {
        $view_data = array();
        
        // get user's data
        $view_data['user'] = $this->user;
        
        //get user's trips
        $user_tripids = $this->Trip_m->get_tripids_by_uid($this->user['uid']);
        foreach($user_tripids as $user_tripid) {
            $view_data['trips'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
        }
                
        // get friends' data
        //THIS SHOWS USER'S FRIENDS ON NOQNOK
        $view_data['user_friends'] = $this->User_m->get_friends_by_uid($this->user['uid']);
        //THIS SHOULD SHOW HER FRIENDS' TRIPS FOR WHICH SHE'S SHOWN OR A TRIP THATS PUBLIC TO FRIENDS
        $view_data['friends_trips'] = $this->Trip_m->get_user_friends_trips($this->user['uid']);
        foreach($view_data['friends_trips'] as $i => $friends_trip) {
            if ($friends_trip['uid'] == $this->user['uid']) {
                unset($view_data['friends_trips'][$i]);
            }
        }
        foreach($view_data['friends_trips'] as &$friends_trip) {
            $friends_trip['creator'] = $this->User_m->get_user_by_uid($friends_trip['uid']);
        }
                
        //recent activity
        $trip_news = $this->Trip_m->get_trip_news_for_user($this->user['uid']);
        $view_data['news_feed_data'] = $trip_news;
        
        $this->load->view('home', $view_data);
    }
    
    function test() {
        $user_tripids = $this->Trip_m->get_tripids_by_uid($this->user['uid']);
        foreach($user_tripids as $user_tripid) {
            $trips[] = $this->Trip_m->get_trip_by_tripid($user_tripid);
        }
        //$trips = $this->Trip_m->get_trip_by_tripid($user_tripids);
        print_r($trips);
    }
}

