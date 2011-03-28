<?php

class Upload extends DataMapper {
 
    public $has_one = array('user');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'path',
            'label' => 'Path',
            'rules' => array('required')
        ),
    );

    function Upload()
    {
        parent::DataMapper();
    }    
}

/* End of file upload.php */
/* Location: ./application/models/upload.php */