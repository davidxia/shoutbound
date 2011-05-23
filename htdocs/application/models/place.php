<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place extends DataMapper
{
    
    public $has_many = array('user', 'trip', 'post');

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
        $this->user->where('id', $user_id)->include_join_fields()->get();
        if ($this->user->join_is_following == 1)
        {
            $this->stored->is_following = TRUE;
        }
        else
        {
            $this->stored->is_following = FALSE;
        }
    }


    public function get_related_places($user_id = FALSE)
    {
        $this->stored->related_places = array();
        $p = new Place($this->parent);

        if ($user_id)
        {
            $p->get_follow_status_by_user_id($user_id);
        }
        $this->stored->related_places[] = $p->stored;
    }
}

/* End of file place.php */
/* Location: ./application/models/place.php */