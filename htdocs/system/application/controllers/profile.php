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
            $pid = $uid;
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
        $u->get_by_id($pid);

        $u->trip->where('active', 1)->where_in_join_field('user', 'role', array(2,3))->where_join_field('user', 'rsvp', 3)->get();
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
        // get array of friends relations to the user
        $u->user->get();
        $rels_to = array();
        foreach ($u->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
        }
        // get array of friend relations from the user
        // TODO: is there a better way of doing this? like with a 'where' clause in one datamapper call?
        $u->related_user->get();
        $rels_from = array();
        foreach ($u->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
        }
        $friend_ids = array_intersect($rels_to, $rels_from);
        
        foreach ($friend_ids as $friend_id)
        {
            $u->get_by_id($friend_id);
            $friends[] = $u->stored;
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
        $uid = $u->get_logged_in_status();
        $u->get_by_id($uid);

        // get active trips for which profile is a planner or creator and rsvp is yes
        $trips = array();
        $u->get_by_id($pid);

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
    }

    

}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */