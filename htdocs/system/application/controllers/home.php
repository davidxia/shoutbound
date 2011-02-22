<?php

class Home extends Controller {
    
    function Home()
	{
		parent::Controller();
		//authentication
        $this->user = $this->User_m->get_logged_in_user();
        if(!$this->user) { redirect('/'); }
		//TODO: maybe some friend detection here
	}

    function index() {            
        // get tripids for which user is a planner
        $user_tripids = $this->Trip_m->get_planner_tripids_by_uid($this->user['uid']);
        // trips for which user's rsvp is yes
        $user_trips = array();
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
                $user_trips[] = $trip;
            }// elseif($this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $this->user['uid']) == 'awaiting'){
                //$view_data['trips_awaiting'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
            //} elseif($this->Trip_m->get_rsvp_by_tripid_uid($user_tripid, $this->user['uid']) == 'no'){
                //$view_data['trips_no'][] = $this->Trip_m->get_trip_by_tripid($user_tripid);
            //}
        }        
        
        
        // this shows her friends' trips for which she's an advisor
        $friends_tripids = $this->Trip_m->get_friends_tripids_by_uid($this->user['uid']);
        if(count($friends_tripids)){
            $friends_trips = array();
            foreach($friends_tripids as $friends_tripid){
                $friends_trips[] = $this->Trip_m->get_trip_by_tripid($friends_tripid);
            }
            foreach($friends_trips as &$friends_trip) {
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
                        
        // news feed: create an array to hold items arrays
        $trip_news = array();
        // get items for both user's trips and her friends trips
        foreach($user_tripids as $user_tripid){
            $items = $this->Trip_m->get_items_by_tripid($user_tripid);
            // we strip the encapsulating array returned by getting items from each tripid
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
        
        $view_data = array('user' => $this->user,
                           'user_friends' => $this->User_m->get_friends_by_uid($this->user['uid']),
                           'news_feed_data' => $trip_news,
                           'user_trips' => $user_trips,
                           'friends_trips' => $friends_trips,
                          );
        $this->load->view('home', $view_data);
    }
    
    function test() {
    }
}