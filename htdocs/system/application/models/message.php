<?php

class Message extends DataMapper {
 
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
            'field' => 'text',
            'label' => 'Text',
            'rules' => array('trim', 'required')
        ),
        array(
            'field' => 'created',
            'label' => 'Created',
            'rules' => array('required')
        ),
    );

    function Message()
    {
        parent::DataMapper();
    }
    
}

/* End of file message.php */
/* Location: ./application/models/message.php */