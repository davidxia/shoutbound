<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends DataMapper
{
    
    public $has_one = array();

    public $has_many = array(
      'trip',
      'wallitem',
      'place',
      'geoplanet_place',
      'setting',
      'friend',
      'related_user' => array(
        'class' => 'user',
        'other_field' => 'user',
        'reciprocal' => TRUE,
      ),
      'user' => array(
        'other_field' => 'related_user',
      )
    );

    var $validation = array(
        array(
            'field' => 'fid',
            'label' => 'fid',
            'rules' => array('')
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => array('required', 'trim', 'unique', 'valid_email')
        ),
        array(
            'field' => 'bio',
            'label' => 'Biography',
            'rules' => array('trim')
        ),
        array(
            'field' => 'url',
            'label' => 'Personal URL',
            'rules' => array('trim')
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
    

    public function get_logged_in_status()
    {
        $uid = get_cookie('uid');
        $key = get_cookie('key');
        $sig = get_cookie('sig');
        if ($sig == $this->get_sig($uid, $key))
        {
            set_cookie('uid', $uid, 259200);
            set_cookie('key', $key, 259200);
            set_cookie('sig', $sig, 259200);
            return $uid;
        }
        else
        {
            return FALSE;
        }
    }
    

    public function get_sig($uid, $key)
    {
        return md5($uid . '~nokonmyballz~' . $key);
    }
    
    
    public function login($uid)
    {
        set_cookie('uid', $uid, 259200);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($uid, $key);
        set_cookie('key', $key, 259200);
        set_cookie('sig', $sig, 259200);
    }


    public function logout()
    {
        delete_cookie('uid');
        delete_cookie('key');
        delete_cookie('sig');
    }
    
    
    public function email_login()
    {
        // Create a temporary user object
        $u = new User();

        // Get this users stored record via their username
        $u->where('email', $this->email)->get();        

        if ($u->password == md5('davidxia'.$this->password.'isgodamongmen'))
        {
            $u->login($u->id);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function get_current_place()
    {
        $this->geoplanet_place->include_join_fields()->where('timestamp=(SELECT MAX(timestamp) FROM geoplanet_places_users)')->get();
        if ($this->geoplanet_place->id)
        {
            $this->stored->place = $this->geoplanet_place->stored;
        }
    }
    
    
    public function get_places()
    {
        $this->stored->places = array();
        foreach ($this->geoplanet_place->include_join_fields()->order_by('timestamp', 'desc')->get_iterated() as $place)
        {
            $place->stored->timestamp = $place->join_timestamp;
            $this->stored->places[] = $place->stored;
        }
    }
    
    
    public function get_trips()
    {
        $this->trip->where('active', 1)->where_in_join_field('user', 'role', array(5,10))->get();
        return $this->trip;
    }
    
    
    public function get_num_rsvp_yes_trips()
    {
        $this->stored->num_rsvp_yes_trips = $this->trip->where('active', 1)->where_join_field('user', 'rsvp', 9)->count();
    }

    
    public function get_rsvp_yes_trips()
    {
        $this->stored->rsvp_yes_trips = array();
        foreach ($this->trip->where('active', 1)->where_join_field('user', 'rsvp', 9)->get() as $rsvp_yes_trip)
        {
            $rsvp_yes_trip->get_goers();
            $rsvp_yes_trip->get_places();
            $this->stored->rsvp_yes_trips[] = $rsvp_yes_trip->stored;
        }
    }
    
    
    public function get_rsvp_awaiting_trips()
    {
        $this->stored->rsvp_awaiting_trips = array();
        foreach ($this->trip->where('active', 1)->where_join_field('user', 'rsvp', 6)->get() as $rsvp_awaiting_trip)
        {
            $rsvp_awaiting_trip->get_goers();
            $rsvp_awaiting_trip->get_places();
            $this->stored->rsvp_awaiting_trips[] = $rsvp_awaiting_trip->stored;
        }
    }
        
    
    public function get_num_following()
    {
        $this->stored->num_following = $this->related_user->where_join_field($this, 'is_following', 1)->count();
    }
    
    
    public function get_following($user_id = FALSE)
    {
        $this->stored->following = array();
        foreach ($this->related_user->include_join_fields()->get_iterated() as $following)
        {
            if ($following->join_is_following == 1)
            {
                $following->get_current_place();
                if ($user_id)
                {
                    $following->get_follow_status_by_user_id($user_id);
                }
                $this->stored->following[] = $following->stored;
            }
        }
    }
    
    
    public function get_num_following_trips()
    {
        $this->stored->num_following_trips = $this->trip->where('active', 1)->where_in_join_field('user', 'rsvp', 3)->count();
    }
    
    
    public function get_following_trips($user_id = FALSE)
    {
        $this->stored->following_trips = array();
        foreach ($this->trip->where('active', 1)->where_in_join_field('user', 'rsvp', 3)->get() as $following_trip)
        {
            $following_trip->get_goers();
            $following_trip->get_places();
            if ($user_id)
            {
                $following_trip->get_rsvp_by_user_id($user_id);
            }
            $this->stored->following_trips[] = $following_trip->stored;
        }
    }


    public function get_num_followers()
    {
        $this->stored->num_followers = $this->user->where_join_field($this, 'is_following', 1)->count();
    }
    
    
    public function get_followers($user_id = FALSE)
    {
        $this->stored->followers = array();
        foreach ($this->user->include_join_fields()->get_iterated() as $follower)
        {
            if ($follower->join_is_following == 1)
            {
                $follower->get_current_place();
                if ($user_id)
                {
                    $follower->get_follow_status_by_user_id($user_id);
                }
                $this->stored->followers[] = $follower->stored;
            }
        }
    }


    public function get_num_posts()
    {
        $this->stored->num_posts = $this->wallitem->where('active', 1)->order_by('created', 'desc')->count();
    }


    public function get_posts()
    {
        // get user's most recent posts
        $this->stored->posts = array();
        $this->wallitem->where('active', 1)->order_by('created', 'desc')->get();
        foreach ($this->wallitem as $wallitem)
        {
            // generate html for wallitem's places
            $wallitem->get_places();
            $wallitem->get_trips();
            $this->stored->posts[] = $wallitem->stored;
        }
    }
    
    
    public function get_news_feed_items()
    {
        $news_feed_items = array();
        $wi = new Wallitem();

        // get trips associated with user
        $trip_ids = array();
        foreach ($this->trip->where('active', 1)->get() as $trip)
        {
            $trip_ids[] = $trip->id;
        }
        // get these trips' most recent wallitems excluding user's own
        if ( ! empty($trip_ids))
        {
            foreach ($wi->where('active', 1)->where('parent_id', NULL)->where_in_join_field('trip_id', $trip_ids)->where('user_id !=', $this->id)->get_iterated() as $post)
            {
                $post->get_creator();
                $post->get_trips();
                $post->get_places();
                // get replies and attach their places
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
                
                // packages each wallitem with replies into separate array
                $post->stored->replies = $replies;
                $news_feed_items[] = $post->stored;
            }
        }
        
        // get wallitems that are replies to user's wallitems
        /*
        $wallitem_ids = array();
        $this->wallitem->where('active', 1)->get();
        foreach ($this->wallitem as $wallitem)
        {
            $wallitem_ids[] = $wallitem->id;
        }
        $reply_wallitems = array();
        if ( ! empty($wallitem_ids))
        {
            $wi->clear();
            foreach ($wi->where_in('parent_id', $wallitem_ids)->where('user_id !=', $this->id)->get() as $wallitem)
            {
                $wallitem->get_creator();
                $wallitem->get_trips();
                $wallitem->get_places();
                $reply_wallitems[] = $wallitem->stored;
            }        
        }
        */
        
        // get posts from people user follows
        $user_ids = array();
        foreach ($this->related_user->get() as $following)
        {
            $user_ids[] = $following->id;
        }
        // get these users' most recent wallitems
        if ( ! empty($user_ids))
        {
            foreach ($wi->where('active', 1)->where('parent_id', NULL)->where_in('user_id', $user_ids)->get() as $post)
            {
                $post->get_creator();
                $post->get_trips();
                
                // get replies and attach their places
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
                
                // packages each wallitem with replies into separate array
                $post->stored->replies = $replies;

                $news_feed_items[] = $post->stored;                
            }
        }
        
        //$news_feed_items = array_merge($trip_wallitems, $user_wallitems);
        if ($news_feed_items)
        {
            // remove duplicates
            $this->load->helper('dedup');
            dedup($news_feed_items);
            $this->load->helper('quicksort');
            _quicksort($news_feed_items, TRUE);
        }
        
        
        return $news_feed_items;
    }

    
    public function get_role_by_tripid($trip_id)
    {
        $this->trip->include_join_fields()->get_by_id($trip_id);
        return $this->trip->join_role;
    }


    public function get_rsvp_by_tripid($trip_id)
    {
        $this->trip->include_join_fields()->get_by_id($trip_id);
        return $this->trip->join_rsvp;
    }
    
    
    public function get_recent_activities()
    {
        $this->load->helper('activity');

        $this->stored->activities = array();
        $a = new Activitie();
        $a->where('user_id', $this->id)->limit(20)->order_by('timestamp', 'desc')->get_iterated();
        
        foreach ($a as $activity)
        {
            get_source($activity);
            get_parent($activity);
            $this->stored->activities[] = $activity->stored;
        }
        
        
    }
    
    
    public function get_settings()
    {
        $this->stored->settings = array();
        foreach ($this->settings->include_join_fields()->order_by('id', 'asc')->get_iterated() as $setting)
        {
            $this->stored->settings[$setting->id] = $setting->join_is_on;
        }
    }
    
    
    public function get_follow_status_by_place_id($id = FALSE)
    {
        if ( ! $id)
        {
            return FALSE;
        }
        $this->geoplanet_place->where('id', $id)->where_join_field($this, 'is_following', 1)->get();
        if ($this->geoplanet_place->id)
        {
            $this->stored->is_following = TRUE;
        }
        else
        {
            $this->stored->is_following = FALSE;
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
}

/* End of file user.php */
/* Location: ./application/models/user.php */