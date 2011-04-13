<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallitem extends DataMapper
{
        
    public $has_one = array(
        'user',
        'trip',
        'parent' => array(
            'class' => 'wallitem',
            'other_field' => 'wallitem'
        ),
    );
    
    public $has_many = array(
        'wallitem' => array(
            'other_field' => 'parent'
        ),
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
        $u->get_by_id($this->user_id);
        $this->stored->user = $u->stored;
    }
    
    
    public function get_places()
    {
        $this->stored->content = preg_replace_callback('/<place id="(\d+)">/',
            create_function('$matches',
                '$p = new Place();
                 $p->get_by_id($matches[1]);
                 return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
            $this->stored->content);
            
        $this->stored->content = str_replace('</place>', '</a>', $this->stored->content);
        //return $this->content;
    }
    

    public function get_replies()
    {
        $this->wallitem->where('active', 1)->get();
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
    
    
    public function get_likes()
    {
        $l = new Like();
        $l->where('wallitem_id', $this->id)->get();
        $likes = array();
        foreach ($l as $like)
        {
            $likes[] = $like->stored;
        }
        $this->stored->likes = $likes;
    }
    
    
    public function get_trip()
    {
        $t = new Trip();
        $t->get_by_id($this->trip_id);
        $this->stored->trip = $t->stored;
    }
    
    
}

/* End of file wallitem.php */
/* Location: ./application/models/wallitem.php */