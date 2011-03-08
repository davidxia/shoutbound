<?php

class Profile extends Controller
{
    
    function Profile()
    {
        parent::Controller();
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
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

    

}

