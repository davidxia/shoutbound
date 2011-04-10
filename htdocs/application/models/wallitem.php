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
    
    
    public function get_creator()
    {
        $u = new User();
        $u->get_by_id($this->stored->user_id);
        $this->stored->user_name = $u->name;
    }
    
    
    public function get_places()
    {
        $this->stored->content = preg_replace_callback('/<place id="(\d+)">/',
            create_function('$matches',
                '$p = new Place();
                 $p->get_by_id($matches[1]);
                 return \'<a class="place" href="#" address="\'.$p->address.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
            $this->stored->content);
            
        $this->stored->content = str_replace('</place>', '</a>', $this->stored->content);
        //return $this->content;
    }
    

    public function get_replies()
    {
        $this->wallitem->get();
        /*
        $replies = array();
        foreach ($this->wallitem as $wallitem)
        {
            $replies[] = $wallitem->stored;
        }
        */
        return $this->wallitem;
        //return $replies;
    }
}

/* End of file wallitem.php */
/* Location: ./application/models/wallitem.php */