<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends DataMapper
{
 
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

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file upload.php */
/* Location: ./application/models/upload.php */