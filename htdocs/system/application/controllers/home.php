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
        
        // logged in user
        $view_data['user'] = $this->user;
        // profile user
        $view_data['profile_user'] = $this->User_m->get_user_by_uid($this->user['uid']);
        $view_data['trips'] = $this->Trip_m->get_user_trips($this->user['uid']);
        $view_data['user_friends'] = $this->User_m->get_friends_by_uid($this->user['uid']);
        
        //news feed!
        $trip_news = $this->Trip_m->get_trip_news_for_user($this->user['uid']);
        $view_data['news_feed_data'] = $trip_news;
        
        $this->load->view('home', $view_data);
    }
}

