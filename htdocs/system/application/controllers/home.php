<?php

class Home extends Controller
{
    
    function Home()
    {
        parent::Controller();
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');
        }
        // TODO: maybe some friend detection here
    }
	

    function index()
    {
        $uid = get_cookie('uid');       
        $u = new User();
        $u->get_by_id($uid);
        
        $t = new Trip();
        
        // get active trips for which user is a planner or creator and rsvp is yes
        $trips = array();
        $u->trip->where('active', 1)->where_in_join_field('user', 'role', array(2,3))->get();
        foreach ($u->trip as $trip)
        {
            // get creators and planners who are going on this trip
            $users = new User();
            $users->where_join_field('trip', 'rsvp', 3)->where_in_join_field('trip', 'role', array(2,3))->get_by_related_trip('id', $trip->id);
            $trip->stored->users = array();
            foreach ($users->all as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            
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
        
        // get active trips for which user is an advisor
        $advising_trips = array();
        $u->trip->where('active', 1)->where_join_field('user', 'role', 1)->get();
        foreach ($u->trip->all as $trip)
        {
            // get creators and planners who are going on this trip
            $users = new User();
            $users->where_join_field('trip', 'rsvp', 3)->where_in_join_field('trip', 'role', array(2,3))->get_by_related_trip('id', $trip->id);
            foreach ($users->all as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            $advising_trips[] = $trip->stored;
            
        }
        
        foreach ($trips as $trip)
        {
            $trip_ids[] = $trip->id;
        }
        // get suggestions for both user's trips and her friends trips
        $s = new Suggestion();
        $s->order_by('created', 'desc');
        $s->where_in('trip_id', $trip_ids)->where('active', 1)->get();
        foreach ($s as $suggestion)
        {
            $suggestion->stored->user_fid = $u->get_by_id($suggestion->user_id)->fid;
            $suggestion->stored->user_name = $u->name;
            $suggestion->stored->trip_name = $t->get_by_id($suggestion->trip_id)->name;
            $suggestion->stored->is_location = 1;
            $news_feed_items[] = $suggestion->stored;
        }
        
        // get messages for both user's trips and her friends trips
        $m = new Message();
        $m->order_by('created', 'desc');
        $m->where_in('trip_id', $trip_ids)->where('active', 1)->get();
        foreach ($m as $message)
        {
            $message->stored->user_fid = $u->get_by_id($message->user_id)->fid;
            $message->stored->user_name = $u->name;
            $message->stored->trip_name = $t->get_by_id($message->trip_id)->name;
            $message->stored->is_location = 0;
            $news_feed_items[] = $message->stored;
        }
        
        $this->load->helper('quicksort');
        _quicksort($news_feed_items);
        
        // get pending friend requests
        // get array of friends relations to the user
        $u->user->get();
        $rels_to = array();
        foreach ($u->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
        }
        // compare with array of friend relations from the user
        // TODO: is there a better way of doing this? like with a 'where' clause in one datamapper call?
        $u->related_user->get();
        $rels_from = array();
        foreach ($u->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
        }
        $num_friend_requests = count(array_diff($rels_to, $rels_from));

        
        $view_data = array('user' => $u->stored,
                           'trips' => $trips,
                           'advising_trips' => $advising_trips,
                           'news_feed_items' => $news_feed_items,
                           'num_friend_requests' => $num_friend_requests,
                           );
                          
        $this->load->view('home', $view_data);
        
    }
    
    
    function test()
    {
        $u = new User();
        $u->get_by_id(15);
        
        // get pending friend requests
        // get array of friends relations to the user
        $u->user->get();
        $rels_to = array();
        foreach ($u->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
            echo $rel_to->id.'<br/>';
        }
        // compare with array of friend relations from the user
        echo '////////////////////////<br/>';
        $u->related_user->get();
        $rels_from = array();
        foreach ($u->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
            echo $rel_from->id.'<br/>';
        }
        //print_r($rels_from);
        echo '///////////////<br/>';
        echo count(array_diff($rels_to, $rels_from));
        //print_r($requests);
        
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */