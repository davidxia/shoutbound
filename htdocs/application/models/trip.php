<?php

class Trip extends DataMapper {
 
    public $has_many = array('user', 'suggestion', 'destination', 'trip_share');

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
    
}

/* End of file trip.php */
/* Location: ./application/models/trip.php */