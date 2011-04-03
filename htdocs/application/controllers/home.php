<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
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
        $users = new User();
        foreach ($u->trip as $trip)
        {
            // get creator and planners who are going on this trip
            $users->where_join_field('trip', 'rsvp', 3)->where_in_join_field('trip', 'role', array(2,3))->get_by_related_trip('id', $trip->id);
            $trip->stored->users = array();
            foreach ($users as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            
            // get trip's destinations
            $d = new Destination();
            $d->where('trip_id', $trip->id)->get();
            $trip->stored->destinations = array();
            foreach ($d as $destination)
            {
                $trip->stored->destinations[] = $destination->stored;
            }

            $trips[] = $trip->stored;
        }
        
        // get active trips for which user is an advisor
        $advising_trips = array();
        $u->trip->where('active', 1)->where_join_field('user', 'role', 1)->get();
        foreach ($u->trip as $trip)
        {
            // get creators and planners who are going on this trip
            $users->where_join_field('trip', 'rsvp', 3)->where_in_join_field('trip', 'role', array(2,3))->get_by_related_trip('id', $trip->id);
            foreach ($users as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            $advising_trips[] = $trip->stored;
        }
        
        // get suggestions for both user's trips and her friends trips
        $news_feed_items = array();
        foreach ($trips as $trip)
        {
            $trip_ids[] = $trip->id;
        }
        if ( ! empty($trip_ids))
        {
            $s = new Suggestion();
            $s->order_by('created', 'desc');
            $s->where_in('trip_id', $trip_ids)->where('active', 1)->get();
            foreach ($s as $suggestion)
            {
                //$suggestion->stored->user_fid = $u->get_by_id($suggestion->user_id)->fid;
                $suggestion->stored->user_name = $u->name;
                $suggestion->stored->profile_pic = $u->profile_pic;
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
                //$message->stored->user_fid = $u->get_by_id($message->user_id)->fid;
                $message->stored->user_name = $u->name;
                $message->stored->profile_pic = $u->profile_pic;
                $message->stored->trip_name = $t->get_by_id($message->trip_id)->name;
                $message->stored->is_location = 0;
                $news_feed_items[] = $message->stored;
            }
        }        
        
        if (isset($news_feed_items[0]))
        {
            $this->load->helper('quicksort');
            _quicksort($news_feed_items);
        }
        
        // get pending friend requests
        // get array of friends relations to the user
        $u->get_by_id($uid);
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
    
    
    function fb_request_form()
    {
        $this->load->view('fb_request_form');
    }
    
    
    function simplegeo_test()
    {
        $this->load->view('simplegeo_test');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */