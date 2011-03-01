<?php

class Trip extends DataMapper {
 
    public $has_many = array('user', 'suggestion', 'destination');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        ),
    );

    function Trip()
    {
        parent::DataMapper();
    }
    
}

/* End of file trip.php */
/* Location: ./application/models/trip.php */