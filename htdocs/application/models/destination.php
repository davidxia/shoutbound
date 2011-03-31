<?php

class Destination extends DataMapper
{
 
    public $has_one = array('trip');

    var $validation = array(
        array(
            'field' => 'trip_id',
            'label' => 'Trip',
            'rules' => array('required')
        ),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'lat',
            'label' => 'Lat',
            'rules' => array('required')
        ),
        array(
            'field' => 'lng',
            'label' => 'Lng',
            'rules' => array('required')
        ),
        array(
            'field' => 'startdate',
            'label' => 'Start date',
            'rules' => array('')
        ),
        array(
            'field' => 'enddate',
            'label' => 'End date',
            'rules' => array('')
        ),
    );

    function __construct()
    {
        parent::__construct();
    }
    
}

/* End of file trip.php */
/* Location: ./application/models/destination.php */