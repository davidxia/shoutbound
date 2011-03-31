<?php

class User extends DataMapper
{
    
    public $has_one = array('setting');

    public $has_many = array(
      'trip',
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

    function get_logged_in_status()
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
    

    function get_sig($uid, $key)
    {
        return md5($uid . '~nokonmyballz~' . $key);
    }
    
    
    function login($uid)
    {
        set_cookie('uid', $uid, 7200);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($uid, $key);
        set_cookie('key', $key, 7200);
        set_cookie('sig', $sig, 7200);
    }


    function logout()
    {
        delete_cookie('uid');
        delete_cookie('key');
        delete_cookie('sig');
    }
    
    
    function email_login()
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
}

/* End of file user.php */
/* Location: ./application/models/user.php */