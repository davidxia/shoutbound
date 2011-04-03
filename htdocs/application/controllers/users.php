<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
 
    function __construct()
    {
        parent::__construct();        
    }
 

    public function logout()
    {
        $u = new User();
        $u->logout();
        redirect('/');
    }
                

    public function ajax_get_logged_in_status()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        
        if ($uid)
        {
            json_success(array('loggedin'=>$uid));
        }
        else
        {
            json_success(array('loggedin'=>FALSE));        
        }
    }
    
    
    public function login_signup()
    {
        $render_string = $this->load->view('login_signup', '', true);
        json_success(array('data'=>$render_string));
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */