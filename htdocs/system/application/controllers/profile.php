<?php

class Profile extends Controller
{
    
    function Profile()
    {
        parent::Controller();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid)
        {
            redirect('/');            
        }
		}
		

    function index($uid = FALSE)
    {
        $u = new User();

        if ( ! $uid)
        {
            $uid = $u->get_logged_in_status();
        }
        $u->get_by_id($uid);

        // get active trips for which user is a planner or creator and rsvp is yes
        $trips = array();
        $u->trip->where('active', 1)->where_in_join_field('user', 'role', array(2,3))->get();
        foreach ($u->trip as $trip)
        {
            // get trip's destinations
            $d = new Destination();
            $d->where('trip_id', $trip->id)->get();
            $trip->stored->destinations = array();
            foreach ($d->all as $destination)
            {
                $trip->stored->destinations[] = $destination->stored;
            }

            $trips[] = $trip->stored;
        }
        
        // get user's Shoutbound friends (we shouldn't display their FB friends publicly)
        $friends = array();
        $u->related_user->get();
        foreach ($u->related_user as $friend)
        {
            $friends[] = $friend->stored;
        }
        
        $view_data = array(
            'user' => $u->stored,
            'trips' => $trips,
            'friends' => $friends,
        );
        
        $this->load->view('profile', $view_data);
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

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */