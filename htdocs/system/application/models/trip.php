<?php

class Trip extends DataMapper {
 
    public $has_many = array('user');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        )
    );

    function Trip()
    {
        parent::DataMapper();
    }
    
}