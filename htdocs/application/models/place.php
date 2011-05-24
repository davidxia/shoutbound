<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place extends DataMapper
{
    
    public $has_many = array(
        'user',
        'trip',
        'post',
        'related_place' => array(
            'class' => 'place',
            'other_field' => 'place',
            'reciprocal' => TRUE,
        ),
        'place' => array(
            'other_field' => 'related_place',
        )
    );

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
        

    public function get_num_posts()
    {
        $this->stored->num_posts = $this->post->where_join_field($this, 'is_active', 1)->count();
    }


    public function get_posts()
    {        
		    $this->stored->posts = array();
        foreach ($this->post->where('parent_id', NULL)->where('is_active', 1)->order_by('created', 'asc')->get_iterated() as $post)
        {
            $post->get_creator();
            $post->convert_nl();
            $post->get_places();
            $post->get_likes();
            
            $r = $post->get_replies();
            $replies = array();
            foreach ($r as $reply)
            {
                $reply->get_creator();
                $reply->convert_nl();
                $reply->get_places();
                $reply->get_likes();
                $replies[] = $reply->stored;
            }
            
            $post->stored->replies = $replies;
            $this->stored->posts[] = $post->stored;
        }
    }


    public function get_num_trips()
    {
        $this->stored->num_trips = $this->trip->where('is_active', 1)->count();
    }
    
    
    public function get_trips()
    {
        $this->stored->trips = array();
        foreach ($this->trip->where('is_active', 1)->get_iterated() as $trip)
        {
            $trip->get_goers();
            $trip->get_places();
            $this->stored->trips[] = $trip->stored;
        }
    }
    

    public function get_num_followers()
    {
        $this->stored->num_followers = $this->user->where_join_field($this, 'is_following', 1)->count();
    }
    
    
    public function get_followers($user_id = FALSE)
    {
        $this->stored->followers = array();
        foreach ($this->user->where_join_field($this, 'is_following', 1)->get_iterated() as $follower)
        {
            if ($user_id)
            {
                $follower->get_follow_status_by_user_id($user_id);
            }
            $this->stored->followers[] = $follower->stored;
        }
    }
    
    
    public function get_follow_status_by_user_id($user_id)
    {
        $CI =& get_instance();
        $key = 'follow_status_by_placeid_userid:'.$this->id.':'.$user_id;
        $val = $CI->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->user->where('id', $user_id)->include_join_fields()->get();
            if ($this->user->join_is_following == 1)
            {
                $val = 1;
            }
            else
            {
                $val = 0;
            }
            $CI->mc->set($key, $val);
        }

        $this->stored->is_following = $val;
    }


    public function get_related_places($user_id = FALSE)
    {
        $CI =& get_instance();
        $key = 'related_places_by_place_id:'.$this->id;
        $val = $CI->mc->get($key);
        $p = new Place();
        
        if ($val === FALSE)
        {
            $val = array();
            $p->get_by_id($this->parent);
            $val[] = clone $p->stored;
            foreach ($this->related_place->get_iterated() as $place)
            {
                $val[] = clone $place->stored;
            }
            $CI->mc->set($key, $val);
        }

        if ($user_id)
        {
            foreach ($val as $k => $v)
            {
                $p->clear();
                $p->get_by_id($val[$k]->id);
                $p->get_follow_status_by_user_id($user_id);
                
                $val[$k]->is_following = $p->stored->is_following;
            }
            
        }
        $this->stored->related_places = $val;
    }
}

/* End of file place.php */
/* Location: ./application/models/place.php */