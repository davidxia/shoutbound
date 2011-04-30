<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geoplanet_place extends DataMapper
{
    
    public $has_many = array('user', 'trip', 'wallitem');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
        

    public function get_num_posts()
    {
        $this->stored->num_posts = $this->wallitem->where_join_field($this, 'is_active', 1)->count();
    }


    public function get_posts()
    {        
		    $this->stored->posts = array();
        foreach ($this->wallitem->where('parent_id', NULL)->where('active', 1)->order_by('created', 'asc')->get_iterated() as $post)
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
        $this->stored->num_trips = $this->trip->where('active', 1)->count();
    }
    

    public function get_num_followers()
    {
        $this->stored->num_followers = $this->user->where_join_field($this, 'is_following', 1)->count();
    }
    
    
}

/* End of file place.php */
/* Location: ./application/models/place.php */