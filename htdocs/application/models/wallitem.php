<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallitem extends DataMapper
{
        
    public $has_one = array(
        'user',
        'parent' => array(
            'class' => 'wallitem',
            'other_field' => 'wallitem'
        ),
    );
    
    public $has_many = array(
        'trip',
        'geoplanet_place',
        'wallitem' => array(
            'other_field' => 'parent'
        ),
    );

    var $validation = array(
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

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    
    
    public function get_creator()
    {
        $u = new User();
        $u->get_by_id($this->user_id);
        $this->stored->user = $u->stored;
    }
    
    
    public function convert_nl()
    {
        $this->stored->content = nl2br($this->stored->content);
    }
    
    
    public function get_places()
    {
        $this->stored->content = preg_replace_callback('/<place id="(\d+)">/',
            create_function('$matches',
                '$p = new Geoplanet_place();
                 $p->get_by_id($matches[1]);
                 return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
            $this->stored->content);
            
        $this->stored->content = str_replace('</place>', '</a>', $this->stored->content);
    }
    

    public function get_replies()
    {
        $this->wallitem->where('active', 1)->order_by('created', 'asc')->get();
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
    
    
    public function get_trips()
    {
        $this->stored->trips = array();
        foreach ($this->trips->where('active', 1)->get() as $trip)
        {
            $trip->get_places();
            $this->stored->trips[] = $trip->stored;
        }
    }
    
    
}

/* End of file wallitem.php */
/* Location: ./application/models/wallitem.php */