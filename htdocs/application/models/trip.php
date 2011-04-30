<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip extends DataMapper {
 
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
        foreach ($this->user->where_join_field($this, 'rsvp', 9)->get() as $goer)
        {
            $this->stored->goers[] = $goer->stored;
        }
    }
    
    
    public function get_followers()
    {
        $this->stored->followers = array();
        foreach ($this->user->where_join_field($this, 'rsvp', 3)->get() as $follower)
        {
            $this->stored->followers[] = $follower->stored;
        }
    }


    public function get_places()
    {
        $this->stored->places = array();
        foreach ($this->place->include_join_fields()->get() as $place)
        {
            $place->stored->startdate = $place->join_startdate;
            $place->stored->enddate = $place->join_enddate;
            $this->stored->places[] = $place->stored;
        }
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