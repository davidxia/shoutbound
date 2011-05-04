<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip extends DataMapper
{
 
    public $has_many = array('user', 'place', 'geoplanet_place', 'wallitem', 'suggestion', 'destination', 'trip_share');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'response_deadline',
            'label' => 'Deadline',
            'rules' => array('')
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => array('trim')
        ),
    );

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    
    
    public function get_creator()
    {
        $this->user->where_join_field($this, 'rsvp', 9)->where_join_field($this, 'role', 10)->get();
        $this->stored->creator = $this->user->stored;
    }
    
    
    public function get_goers()
    {
        $this->stored->goers = array();
        foreach ($this->user->where_in_join_field($this, 'rsvp', array(6,9))->get_iterated() as $goer)
        {
            $this->stored->goers[] = $goer->stored;
        }
    }
    
    
    public function get_followers($user_id = FALSE)
    {
        $this->stored->followers = array();
        foreach ($this->user->where_join_field($this, 'rsvp', 3)->get_iterated() as $follower)
        {
            if ($user_id)
            {
                $follower->get_follow_status_by_user_id($user_id);
            }
            $this->stored->followers[] = $follower->stored;
        }
    }


    public function get_places()
    {
        $this->stored->places = array();
        foreach ($this->geoplanet_place->include_join_fields()->get_iterated() as $place)
        {
            $place->stored->startdate = $place->join_startdate;
            $place->stored->enddate = $place->join_enddate;
            $this->stored->places[] = $place->stored;
        }
    }
        
    
    public function get_posts()
    {
		    $posts = array();
        foreach ($this->wallitem->where('parent_id', NULL)->where('active', 1)->order_by('created', 'asc')->get_iterated() as $post)
        {
            // get creator's name
            $post->get_creator();
            // convert \n to <br/>
            $post->convert_nl();
            // generate html for wallitem's places
            $post->get_places();
            // get number of likes
            $post->get_likes();
            $post->get_trips();
            
            // get replies and attach their places
            $r = $post->get_replies();
            $replies = array();
            foreach ($r as $reply)
            {
                $reply->get_creator();
                $reply->convert_nl();
                $reply->get_places();
                $reply->get_likes();
                $replies[] = $reply->stored;
            }
            
            // packages each wallitem with replies into separate array
            $post->stored->replies = $replies;
            $posts[] = $post->stored;
        }
        
        return $posts;
    }


    // checks if trip is associated with place
    // if so it updates start and enddates
    // if not it adds new row in places_trips table
    public function save_place_trip($place, $startdate=NULL, $enddate=NULL)
    {
        $this->place->where_join_field($this, 'place_id', $place->id)->get();

        if ($this->place->id)
        {
            $this->set_join_field($place, 'startdate', $startdate);
            $this->set_join_field($place, 'enddate', $enddate);
        }
        else
        {
            $place->save($this);
            $this->set_join_field($place, 'startdate', $startdate);
            $this->set_join_field($place, 'enddate', $enddate);
        }
        
        return TRUE;
    }
    
    
    public function delete($trip_id = FALSE, $user_id = FALSE)
    {
        if ( ! $trip_id OR ! $user_id)
        {
            return FALSE;
        }
        
        //check if trip exists in trips table and is active, ie not deleted
        if ( ! $this->active)
        {
            return FALSE;
        }
        
        //check if user is the creator, redirect to home page otherwise
        $this->user->include_join_fields()->where_join_field($this, 'user_id', $user_id)->get();
        if ($this->user->join_role != 10)
        {
            return FALSE;
        }

        $this->where('id', $trip_id)->update('active', 0);
        $num_affected = $this->db->affected_rows();
        if ($num_affected == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function get_rsvp_by_user_id($user_id)
    {
        $this->user->where('id', $user_id)->include_join_fields()->get();
        $this->stored->rsvp = $this->user->join_rsvp;
        $this->stored->rsvp = $this->user->join_rsvp;
    }
}

/* End of file trip.php */
/* Location: ./application/models/trip.php */