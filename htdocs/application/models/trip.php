<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip extends DataMapper {
 
    public $has_many = array('user', 'place', 'wallitem', 'suggestion', 'destination', 'trip_share');

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

    function __construct()
    {
        parent::__construct();
    }
    
    
    public function get_creator()
    {
        $this->user->where_join_field($this, 'rsvp', 3)->where_join_field($this, 'role', 3)->get();
        return $this->user->stored;
    }
    
    
    public function get_goers()
    {
        $users = array();
        $this->user->where_join_field($this, 'rsvp', 3)->where_in_join_field($this, 'role', array(2,3))->get();
        foreach ($this->user as $user)
        {
            $users[] = $user->stored;
        }
        return $users;
    }


    public function get_places()
    {
        $this->place->include_join_fields()->get();
        $places = array();
        foreach ($this->place as $place)
        {
            $place->stored->startdate = $place->join_startdate;
            $place->stored->enddate = $place->join_enddate;
            $places[] = $place->stored;
        }
        
        return $places;
    }
    
    
    public function get_wallitems()
    {
		    $wallitems = array();
        $this->load->helper('quicksort');
		    
        $this->wallitem->where('parent_id', NULL)->where('active', 1)->get();
        foreach ($this->wallitem as $wallitem)
        {
            // get creator's name
            $wallitem->get_creator();
            // convert \n to <br/>
            $wallitem->convert_nl();
            // generate html for wallitem's places
            $wallitem->get_places();
            // get number of likes
            $wallitem->get_likes();
            
            // get replies and attach their places
            $r = $wallitem->get_replies();
            $replies = array();
            foreach ($r as $reply)
            {
                // get creator's name
                $reply->get_creator();
                $reply->convert_nl();
                // generate html for wallitem's places
                $reply->get_places();
                // get number of likes
                $reply->get_likes();
                $replies[] = $reply->stored;
            }
            
            if ($replies)
            {
                _quicksort($replies);
            }
            // packages each wallitem with replies into separate array
            $wallitem->stored->replies = $replies;
            $wallitems[] = $wallitem->stored;
        }
        
        if ($wallitems)
        {
            _quicksort($wallitems);
        }
        return $wallitems;
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
}

/* End of file trip.php */
/* Location: ./application/models/trip.php */