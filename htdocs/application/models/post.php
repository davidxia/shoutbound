<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends DataMapper
{
    private $mc;
    
    public $has_one = array(
        'user',
        'parent' => array(
            'class' => 'post',
            'other_field' => 'post'
        ),
    );
    
    public $has_many = array(
        'trip',
        'place',
        'post' => array(
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
        $this->mc = new Mc();
    }
    
    
    public function get_creator()
    {
        $key = 'creator_by_post_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $u = new User($this->user_id);
            $val = $u->stored;
            $this->mc->set($key, $val);
        }
        
        $this->stored->user = $val;
    }
    
    
    public function get_added_by($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            return FALSE;
        }
        $key = 'adder_by_postid_tripid:'.$this->id.':'.$trip_id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->trip->where('id', $trip_id)->include_join_fields()->get();
            $u = new User($this->trip->join_added_by);
            if ($u->id)
            {
                $val = $u->stored;
            }
            $this->mc->set($key, $val);
        }
        
        $this->stored->added_by = $val;
    }
    
    
    public function convert_nl()
    {
        $this->stored->content = nl2br($this->stored->content);
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
    }
    

    public function get_replies()
    {
        $key = 'replies_by_post_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->post->where('is_active', 1)->order_by('created', 'asc')->get_iterated() as $reply)
            {
                $val[] = $reply->stored;
            }
            $this->mc->set($key, $val);
        }

        $this->stored->replies = $val;
    }
    
    
    public function get_likes()
    {
        $l = new Like();
        $l->where('post_id', $this->id)->get();
        $likes = array();
        foreach ($l as $like)
        {
            $likes[] = $like->stored;
        }
        $this->stored->likes = $likes;
    }
    
    
    public function get_trips()
    {
        $key = 'trips_by_post_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->trips->where('is_active', 1)->where_join_field('post', 'is_active', 1)->get_iterated() as $trip)
            {
                $trip->get_places();
                $val[] = $trip->stored;
            }
            $this->mc->set($key, $val);
        }

        $this->stored->trips = $val;
    }    
    
}

/* End of file post.php */
/* Location: ./application/models/post.php */