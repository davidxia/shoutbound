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
        // only keep tripids of trips for which user is a planner
        foreach($user_tripids as $i=>$tripid) {
            if($this->Trip_m->get_type_by_tripid_uid($tripid, $this->user['uid']) == 'advisor') {
                unset($user_tripids[$i]);
            }
        }
        foreach($user_tripids as $user_tripid) {
            $view_data['trips'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
        }
                
        // get friends' data
        //THIS SHOWS USER'S FRIENDS ON NOQNOK
        $view_data['user_friends'] = $this->User_m->get_friends_by_uid($this->user['uid']);
        //THIS SHOWS HER FRIENDS' TRIPS FOR WHICH SHE'S AN ADVISOR
        $view_data['friends_trips'] = $this->Trip_m->get_friends_trips($this->user['uid']);
        // get the planners' names of each trip
        foreach($view_data['friends_trips'] as &$friends_trip) {
            // get uids associated with each tripid
            $uids = $this->Trip_m->get_uids_by_tripid($friends_trip['tripid']);
            foreach($uids as $uid) {
                $friends_trip['users'][] = $this->User_m->get_user_by_uid($uid);
            }
        }
                
        //recent activity
        $trip_news = $this->Trip_m->get_trip_news_for_user($this->user['uid']);
        $view_data['news_feed_data'] = $trip_news;
        
        $this->load->view('home', $view_data);
    }
    
    function test() {


    }
}

