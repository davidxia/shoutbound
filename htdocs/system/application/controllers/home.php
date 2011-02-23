<?php

class Home extends Controller {
    
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
        
        // get active trips for which user is a planner and rsvp is yes
        $u->trip->where('active', 1)->where_join_field('user', 'role', 2)->where_join_field('user', 'rsvp', 3)->get();
        foreach ($u->trip->all as $trip)
        {
            // get users who are going on this trip
            $users = new User();
            $users->where_join_field('trip', 'rsvp', 3)->where_join_field('trip', 'role', 2)->get_by_related_trip('id', $trip->id);
            foreach ($users->all as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            $trips[] = $trip->stored;
            
        }
        
        // get active trips for which user is an advisor
        $u->trip->where('active', 1)->where_join_field('user', 'role', 1)->get();
        foreach ($u->trip->all as $trip)
        {
            // get users who are going on this trip
            $users = new User();
            $users->where_join_field('trip', 'rsvp', 3)->where_join_field('trip', 'role', 2)->get_by_related_trip('id', $trip->id);
            foreach ($users->all as $user)
            {
                $trip->stored->users[] = $user->stored;
            }
            $advising_trips[] = $trip->stored;
            
        }
        
        $view_data = array('user' => $u,
                           //'user_friends' => $this->User_m->get_friends_by_uid($this->user['uid']),
                           //'news_feed_data' => $trip_news,
                           'trips' => $trips,
                           'advising_trips' => $advising_trips);
                          
        $this->load->view('home', $view_data);
        
    }
    
    function test()
    {
    }
}