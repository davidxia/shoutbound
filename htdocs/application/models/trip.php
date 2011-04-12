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