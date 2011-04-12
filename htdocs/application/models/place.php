<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place extends DataMapper
{
    
    public $has_many = array('trip', 'wallitem');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'ascii_name',
            'label' => 'Ascii Name',
            'rules' => array('trim')
        ),
        array(
            'field' => 'lat',
            'label' => 'Lat',
            'rules' => array('required')
        ),
        array(
            'field' => 'lng',
            'label' => 'Lng',
            'rules' => array('required')
        ),
    );

    function __construct()
    {
        parent::__construct();
    }
    
}

/* End of file place.php */
/* Location: ./application/models/place.php */