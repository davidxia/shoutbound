<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends DataMapper
{
    
    public $has_one = array('setting');

    public $has_many = array(
      'trip',
      'wallitem',
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
        set_cookie('uid', $uid, 7200);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($uid, $key);
        set_cookie('key', $key, 7200);
        set_cookie('sig', $sig, 7200);
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
        $this->trip->where('active', 1)->where_in_join_field('user', 'role', array(2,3))->get();
        return $this->trip;
    }
    
    
    public function get_advising_trips()
    {
        $this->trip->where('active', 1)->where_in_join_field('user', 'role', 1)->get();
        return $this->trip;
    }
    
    
    public function get_news_feed_items()
    {
        $news_feed_items = array();
        
        // get trips associated with user
        $trip_ids = array();
        foreach ($this->trip->where('active', 1)->get() as $trip)
        {
            $trip_ids[] = $trip->id;
        }
        // get these trips' most recent wallitems excluding user's own
        $trip_wallitems = array();
        $wi = new Wallitem();
        foreach ($wi->where('active', 1)->where_in('trip_id', $trip_ids)->where('user_id !=', $this->id)->get() as $wallitem)
        {
            $trip_wallitems[] = $wallitem->stored;
        }
        
        // get wallitems that are replies to user's wallitems
        $wallitem_ids = array();
        $this->wallitem->where('active', 1)->get();
        foreach ($this->wallitem as $wallitem)
        {
            $wallitem_ids[] = $wallitem->id;
        }
        $wi = new Wallitem();
        $reply_wallitems = array();
        foreach ($wi->where_in('parent_id', $wallitem_ids)->where('user_id !=', $this->id)->get() as $wallitem)
        {
            $reply_wallitems[] = $wallitem->stored;
        }
          
        
        return array_merge($trip_wallitems, $reply_wallitems);
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
}

/* End of file user.php */
/* Location: ./application/models/user.php */