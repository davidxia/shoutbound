<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends DataMapper
{
    
    public $has_one = array('setting');

    public $has_many = array(
      'trip',
      'wallitem',
      'place',
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

    function __construct()
    {
        parent::__construct();
    }
    
	
    ////////////////////////////////////////////////////////////
    // Logging Users in and out

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
    
    
    public function get_num_followers()
    {
        $this->stored->num_followers = $this->user->count();
    }
    
    
    public function get_followers()
    {
        $this->stored->followers = array();
        foreach ($this->user->get() as $follower)
        {
            $this->stored->followers[] = $follower->stored;
        }
    }
    
    
    public function get_num_following()
    {
        $this->stored->num_following = $this->related_user->count();
    }
    
    
    public function get_following()
    {
        $this->stored->following = array();
        foreach ($this->related_user->get() as $following)
        {
            $this->stored->following[] = $following->stored;
        }
    }
    
    
    public function get_num_following_trips()
    {
        $this->stored->num_following_trips = $this->trip->where('active', 1)->where_in_join_field('user', 'rsvp', 3)->count();
    }
    
    
    public function get_following_trips()
    {
        $this->stored->following_trips = array();
        foreach ($this->trip->where('active', 1)->where_in_join_field('user', 'rsvp', 3)->get() as $following_trip)
        {
            $following_trip->get_goers();
            $following_trip->get_places();
            $this->stored->following_trips[] = $following_trip->stored;
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
        $wi = new Wallitem();

        // get trips associated with user
        $trip_ids = array();
        foreach ($this->trip->where('active', 1)->get() as $trip)
        {
            $trip_ids[] = $trip->id;
        }
        // get these trips' most recent wallitems excluding user's own
        $trip_wallitems = array();
        if ( ! empty($trip_ids))
        {
            foreach ($wi->where('active', 1)->where_in_join_field('trip_id', $trip_ids)->where('user_id !=', $this->id)->get() as $wallitem)
            {
                $wallitem->get_creator();
                $wallitem->get_trips();
                $trip_wallitems[] = $wallitem->stored;
            }
        }
        
        // get wallitems that are replies to user's wallitems
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
                $reply_wallitems[] = $wallitem->stored;
            }        
        }
        
        // get posts from people user follows
        $user_ids = array();
        foreach ($this->related_user->get() as $following)
        {
            $user_ids[] = $following->id;
        }
        // get these users' most recent wallitems
        $user_wallitems = array();
        if ( ! empty($user_ids))
        {
            foreach ($wi->where('active', 1)->where_in('user_id', $user_ids)->get() as $wallitem)
            {
                $wallitem->get_creator();
                $wallitem->get_trips();
                $user_wallitems[] = $wallitem->stored;
            }
        }

        
        $news_feed_items = array_merge($trip_wallitems, $reply_wallitems, $user_wallitems);
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
        
    
    public function get_destinations()
    {
        $this->stored->destinations = array();
        foreach ($this->places->get() as $destination)
        {
            $this->stored->destinations[] = $destination->stored;
        }
    }
}

/* End of file user.php */
/* Location: ./application/models/user.php */