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
}

/* End of file user.php */
/* Location: ./application/models/user.php */