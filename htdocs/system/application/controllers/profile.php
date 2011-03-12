<?php

class Profile extends Controller
{
    
    function Profile()
    {
        parent::Controller();
        /*
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid)
        {
            redirect('/');            
        }
        */
		}
		

    function index($pid = FALSE)
    {
        $u = new User();
        $uid = $u->get_logged_in_status();

        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR $uid))
        {
            $this->router->show_404();
            return;
        }
        
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $u->get_by_id($uid);
            $profile = $u->stored;
            $user = $u->stored;
        }
        elseif ( ! $uid)
        {
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                $this->router->show_404();
                return;
            }
            $profile = $u->stored;
            $user = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                $this->router->show_404();
                return;
            }
            $profile = $u->stored;
            $u->get_by_id($uid);
            $user = $u->stored;
        }


        // get active trips for which profile is a planner or creator and rsvp is yes
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
        
        // get profile's Shoutbound friends (we shouldn't display their FB friends publicly)
        $friends = array();
        $u->related_user->get();
        foreach ($u->related_user as $friend)
        {
            $friends[] = $friend->stored;
        }
        
        $view_data = array(
            'user' => $user,
            'profile' => $profile,
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