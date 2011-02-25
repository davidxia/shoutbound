<?php

class Profile extends Controller {
    
    function Profile()
    {
        parent::Controller();
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');
        }
		}
		

    function index()
    {
        $this->details();
    }

    function details($pid=false) {
        
        if ($pid === false)
        {
            $pid = $this->user['uid'];
        }
        
        $view_data = array();
        
        // logged in user
        $view_data['user'] = $this->user;
        // profile user
        $view_data['profile_user'] = $this->User_m->get_user_by_uid($pid);
        $view_data['trips'] = $this->Trip_m->get_user_trips($pid);
        $view_data['profile_user_friends'] = $this->User_m->get_friends_by_uid($pid);
        
        //news feed!
        $trip_news = $this->Trip_m->get_trip_news_for_user($pid);
        $view_data['news_feed_data'] = $trip_news;
        
        $this->load->view('profile', $view_data);
    }

    
    function settings(){
        $view_data = array();
        
        // logged in user
        $view_data['user'] = $this->user;
        $view_data['user_settings'] = $this->User_m->get_settings($this->user['uid']);
        $this->load->view('user_settings', $view_data);
    }


    function ajax_update_settings() {
        $this->User_m->update_settings($this->user['uid'],
            $_POST['trip_suggestion'],
            $_POST['trip_post'],
            $_POST['trip_reply'],
            $_POST['replies']
        );
    }

}

