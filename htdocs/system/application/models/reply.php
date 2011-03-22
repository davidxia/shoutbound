<?php

class Reply extends DataMapper {

    var $table = 'replies';
 
    public $has_one = array('user', 'message', 'suggestion');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
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

    function Reply()
    {
        parent::DataMapper();
    }
    
}

/* End of file reply.php */
/* Location: ./application/models/reply.php */