<?php
class User extends DataMapper {
 
    public $has_many = array('trip');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim', 'max_length' => 255)
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => array('required', 'trim', 'min_length' => 3, 'encrypt')
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => array('required', 'trim', 'unique', 'valid_email')
        )
    );

    function User()
    {
        parent::DataMapper();
    }
    
    // Validation prepping function to encrypt passwords
	function _encrypt($field)
	{
		// Don't encrypt an empty string
		if (!empty($this->{$field}))
		{
			// Generate a random salt if empty
			if (empty($this->salt))
			{
				$this->salt = md5(uniqid(rand(), true));
			}

			$this->{$field} = sha1($this->salt . $this->{$field});
		}
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
            return TRUE;
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
        set_cookie('uid', $uid);
        $key = mt_rand(100000, 999999);
        $sig = $this->get_sig($uid, $key);
        set_cookie('key', $key);
        set_cookie('sig', $sig);
    }


    function logout()
    {
        delete_cookie('uid');
        delete_cookie('key');
        delete_cookie('sig');
    }


    function get_logged_in_user() {
        $uid = $this->get_logged_in_uid();
        if($uid)
            return $this->get_user_by_uid($uid);
        return null;
    }



    
    
}

/* End of file user.php */
/* Location: ./application/models/user.php */