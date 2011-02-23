<?php

class Suggestion extends DataMapper {
 
    public $has_one = array('user', 'trip');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'trip_id',
            'label' => 'Trip',
            'rules' => array('required')
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
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
    );

    function Suggestion()
    {
        parent::DataMapper();
    }
    
}