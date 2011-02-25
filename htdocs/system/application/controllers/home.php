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
        
        $t = new Trip();
        
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
        
        
        // get suggestions for both user's trips and her friends trips
        foreach($trips as $trip)
        {
            //print_r($trip->id);
            $s = new Suggestion();
            $s->where('trip_id', $trip->id)->where('active', 1)->get();
            foreach ($s->all as $suggestion)
            {
                //$u->clear();
                $suggestion->stored->user_fid = $u->get_by_id($suggestion->user_id)->fid;
                $suggestion->stored->user_name = $u->name;
                $suggestion->stored->trip_name = $t->get_by_id($suggestion->trip_id)->name;
                $suggestion->stored->is_location = 1;
                $news_feed_items[] = $suggestion->stored;
            }
        }
        
        
        $view_data = array('user' => $u,
                           //'user_friends' => $this->User_m->get_friends_by_uid($this->user['uid']),
                           'trips' => $trips,
                           'advising_trips' => $advising_trips,
                           'news_feed_items' => $news_feed_items);
                          
        $this->load->view('home', $view_data);
        
    }
    
    function test()
    {
        $s = new Suggestion();
        $s->where('trip_id', 86)->where('active', 1)->get();
        foreach ($s->all as $suggestion)
        {
            print_r($suggestion->stored);
            echo '<br/><br/>';
        }
        //print_r($s);
        //$s->where('trip_id', 86)->get();
        //echo $s->id.'<br/>'.$s->name;
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */