<?php

class Like extends DataMapper
{
 
    public $has_one = array('user', 'message', 'suggestion');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'is_like',
            'label' => 'Is Like',
            'rules' => array('required')
        ),
        array(
            'field' => 'created',
            'label' => 'Created',
            'rules' => array('required')
        ),
    );

    function __construct()
    {
        parent::__construct();
    }
    
}

/* End of file like.php */
/* Location: ./application/models/like.php */