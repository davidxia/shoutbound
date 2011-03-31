<?php

class Setting extends DataMapper
{
    public $has_many = array('user');

    var $validation = array(
        array(
            'field' => 'trip_invite',
            'label' => 'Trip Invite',
            'rules' => array('required')
        ),
        array(
            'field' => 'trip_post',
            'label' => 'Trip Post',
            'rules' => array('required')
        ),
        array(
            'field' => 'post_reply',
            'label' => 'Post Reply',
            'rules' => array('required')
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

}

/* End of file setting.php */
/* Location: ./application/models/setting.php */