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
        
        // get tripids for which user is a planner
        $user_tripids = $this->Trip_m->get_planner_tripids_by_uid($this->user['uid']);
        // trips for which user is a planner and rsvp yes
        foreach($user_tripids as $user_tripid) {
            if($this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $this->user['uid']) == 'yes'){
                $trip = $this->Trip_m->get_trip_by_tripid($user_tripid);
                $trip_uids = $this->Trip_m->get_uids_by_tripid($user_tripid);
                foreach($trip_uids as $trip_uid){
                    $user = $this->User_m->get_user_by_uid($trip_uid);
                    $user['rsvp'] = $this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $trip_uid);
                    $user['role'] = $this->Trip_m->get_type_by_tripid_uid($user_tripid, $trip_uid);
                    $trip['users'][] = $user;
                }
                $view_data['user_trips'][] = $trip;
            }// elseif($this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $this->user['uid']) == 'awaiting'){
                //$view_data['trips_awaiting'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
            //} elseif($this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $this->user['uid']) == 'no'){
                //$view_data['trips_no'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
            //}
        }        
        
        // get friends' data
        // THIS SHOWS USER'S FRIENDS ON SHOUTBOUND
        $view_data['user_friends'] = $this->User_m->get_friends_by_uid($this->user['uid']);
        
        // THIS SHOWS HER FRIENDS' TRIPS FOR WHICH SHE'S AN ADVISOR
        $friends_tripids = $this->Trip_m->get_friends_tripids_by_uid($this->user['uid']);
        if(count($friends_tripids)){
            foreach($friends_tripids as $friends_tripid){
                $view_data['friends_trips'][] = $this->Trip_m->get_trip_by_tripid($friends_tripid);
            }
            foreach($view_data['friends_trips'] as &$friends_trip) {
                // get uids associated with each tripid
                $trip_uids = $this->Trip_m->get_uids_by_tripid($friends_trip['tripid']);
                // get users of these uids
                foreach($trip_uids as $trip_uid) {
                    $user = $this->User_m->get_user_by_uid($trip_uid);
                    $user['rsvp'] = $this->Trip_m->get_rsvp_by_tripid_uid($friends_trip['tripid'], $trip_uid);
                    $user['role'] = $this->Trip_m->get_type_by_tripid_uid($friends_trip['tripid'], $trip_uid);
                    $friends_trip['users'][] = $user;
                }
            }
        }
                        
        // NEWS FEED: create an array to hold items arrays
        $trip_news = array();
        // get items for both user's trips and her friends trips
        foreach($user_tripids as $user_tripid){
            $items = $this->Trip_m->get_items_by_tripid($user_tripid);
            // we strip the encapsulating array returned by
            // getting items from each tripid
            foreach($items as $item){
                // then we push each item array onto the news feed array
                $trip_news[] = $item;
            }
        }
        foreach($friends_tripids as $friends_tripid){
            $items = $this->Trip_m->get_items_by_tripid($friends_tripid);
            foreach($items as $item){
                $trip_news[] = $item;
            }
        }
        $view_data['news_feed_data'] = $trip_news;
        
        $this->load->view('home', $view_data);
    }
    
    function test() {
        // THIS SHOWS HER FRIENDS' TRIPS FOR WHICH SHE'S AN ADVISOR
        $friends_tripids = $this->Trip_m->get_friends_tripids_by_uid($this->user['uid']);
        print_r($friends_tripids); echo '<br/><br/>';
        if(count($friends_tripids)){
            foreach($friends_tripids as $friends_tripid){
                $view_data['friends_trips'][] = $this->Trip_m->get_trip_by_tripid($friends_tripid);
            }
            foreach($view_data['friends_trips'] as &$friends_trip) {
                // get uids associated with each tripid
                $trip_uids = $this->Trip_m->get_uids_by_tripid($friends_trip['tripid']);
                // get users of these uids
                foreach($trip_uids as $trip_uid) {
                    $user = $this->User_m->get_user_by_uid($trip_uid);
                    $user['rsvp'] = $this->Trip_m->get_rsvp_by_tripid_uid($friends_trip['tripid'], $trip_uid);
                    $user['role'] = $this->Trip_m->get_type_by_tripid_uid($friends_trip['tripid'], $trip_uid);
                    $friends_trip['users'][] = $user;
                }
            }
        }
        print_r($view_data['friends_trips']);
    }
}