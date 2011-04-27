<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activitie extends DataMapper
{
    //var $table = 'activities';
 
    public $has_one = array('user');

    var $validation = array(
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'activity_type',
            'label' => 'Activity type',
            'rules' => array('required')
        ),
        array(
            'field' => 'source_id',
            'label' => 'Source ID',
            'rules' => array('required')
        ),
        array(
            'field' => 'parent_id',
            'label' => 'Parent ID',
            'rules' => array('')
        ),
        array(
            'field' => 'parent_type',
            'label' => 'Parent type',
            'rules' => array('')
        ),
        array(
            'field' => 'timestamp',
            'label' => 'Timestamp',
            'rules' => array('required')
        ),
    );

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    
}

/* End of file activitie.php */
/* Location: ./application/models/activitie.php */