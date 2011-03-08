<?php

class Setting extends DataMapper
{
    public $has_many = array('user');

    var $validation = array(
        array(
            'field' => 'trip_suggestion',
            'label' => 'Trip Suggestion',
            'rules' => array('required')
        ),
        array(
            'field' => 'trip_post',
            'label' => 'Trip Post',
            'rules' => array('required')
        ),
        array(
            'field' => 'trip_reply',
            'label' => 'Trip Reply',
            'rules' => array('required')
        ),
        array(
            'field' => 'replies',
            'label' => 'Replies',
            'rules' => array('required')
        ),
    );

    function Setting()
    {
        parent::DataMapper();
    }

}

/* End of file setting.php */
/* Location: ./application/models/setting.php */