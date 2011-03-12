<?php

class Profile extends Controller
{
    
    function Profile()
    {
        parent::Controller();
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
            //$is_friend = -1;
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
            
            if ($pid != $uid)
            {
                $u->related_user->where('id', $pid)->get();
                
                // get profile user's friendship status with this user
                $f = new User();
                $f->get_by_id($pid);
                $f->related_user->where('id', $uid)->get();
                
                if ( ! $u->related_user->id)
                {
                    $is_friend = 0;
                }
                elseif ($u->related_user->id AND ! $f->related_user->id)
                {
                    $is_friend = 1;
                }
                elseif ($u->related_user->id AND $f->related_user->id)
                {
                    $is_friend = 2;
                }
            }
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
            'is_friend' => $is_friend,
        );
        
        $this->load->view('profile', $view_data);
    }
    
    
    function test()
    {
        $u = new User();
        $u->get_by_id(1);
        $f = new User();
        $f->get_by_id(18);
        
        $u->related_user->where('id', 18)->get();
        $f->related_user->where('id', 1)->get();
        
        if ( ! $u->related_user->id)
        {
            echo 'not friends';
        }
        elseif ($u->related_user->id AND ! $f->related_user->id)
        {
            echo 'request pending';
        }
        elseif ($u->related_user->id AND $f->related_user->id)
        {
            echo 'yay friends';
            echo $u->related_user->name;
            echo '<br/><br/>';
        }
        
        
        /*
        foreach ($u->related_user as $friend)
        {
            print_r($friend->name);
            print_r($friend->join_status);
            echo '<br/>';
        }
        */
    }

    

}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */