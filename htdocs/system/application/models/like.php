<?php

class Like extends DataMapper {
 
    public $has_one = array('user', 'message', 'suggestion');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'created',
            'label' => 'Created',
            'rules' => array('required')
        ),
    );

    function Like()
    {
        parent::DataMapper();
    }
    
}

/* End of file like.php */
/* Location: ./application/models/like.php */