<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallitem extends DataMapper
{
        
    public $has_one = array(
        'user',
        'trip',
        'parent' => array(
            'class' => 'wallitem',
            'other_field' => 'wallitem'
        )
    );
    
    public $has_many = array(
        'place',
        'wallitem' => array(
            'other_field' => 'parent'
        )
    );

    var $validation = array(
        array(
            'field' => 'trip_id',
            'label' => 'Trip',
            'rules' => array('required')
        ),
        array(
            'field' => 'user_id',
            'label' => 'User',
            'rules' => array('required')
        ),
        array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'parent_id',
            'label' => 'Parent',
            'rules' => array('')
        ),
        array(
            'field' => 'is_active',
            'label' => 'Active',
            'rules' => array('')
        ),
        array(
            'field' => 'created',
            'label' => 'Created',
            'rules' => array('required')
        ),
    );

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function get_replies()
    {
        $this->wallitem->get();
        $replies = array();
        foreach ($this->wallitem as $wallitem)
        {
            $replies[] = $wallitem->stored;
        }
        
        return $replies;
    }
    
    
    public function get_places()
    {
        $this->place->get();
        $places = array();
        foreach ($this->place as $place)
        {
            $places[] = $place->stored;
        }
        
        return $places;
    }
}

/* End of file wallitem.php */
/* Location: ./application/models/wallitem.php */