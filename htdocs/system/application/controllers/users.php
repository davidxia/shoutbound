<?php

class Users extends Controller
{
 
    function Users()
    {
        parent::Controller();        
    }
 
    function index()
    {
        $this->load->view('facebook_test');
    }
    
    
    function logout()
    {
        $u = new User();
        $u->logout();
        redirect('/');
    }
                

    function ajax_get_logged_in_status()
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
    
    
    function login_signup()
    {
        $render_string = $this->load->view('login_signup', $view_data, true);
        json_success(array('data'=>$render_string));
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */