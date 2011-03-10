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
        
        // put user's planning trips in an array for where_in below
        if (count($trips))
        {
            foreach ($trips as $trip)
            {
                $trip_ids[] = $trip->id;
            }
            // get suggestions for both user's trips and her friends trips
            $s = new Suggestion();
            $s->order_by('created', 'desc');
            $s->where_in('trip_id', $trip_ids)->where('active', 1)->get();
            foreach ($s->all as $suggestion)
            {
                $suggestion->stored->user_fid = $u->get_by_id($suggestion->user_id)->fid;
                $suggestion->stored->user_name = $u->name;
                $suggestion->stored->trip_name = $t->get_by_id($suggestion->trip_id)->name;
                $suggestion->stored->is_location = 1;
                $news_feed_items[] = $suggestion->stored;
            }
        }
        
        
        $view_data = array('user' => $u,
                           'trips' => $trips,
                           'advising_trips' => $advising_trips,
                           'news_feed_items' => $news_feed_items);
                          
        $this->load->view('home', $view_data);
        
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */