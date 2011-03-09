<?php

class Login extends Controller {
 
    function Login()
    {
        parent::Controller();        
    }
    
 
    function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
            
        $this->load->helper('form');
        $this->load->view('login');
    
    }
    
    
    function ajax_email_login()
    {
        $u = new User();
        $u->email = $this->input->post('email');
        $u->password = $this->input->post('password');

        if ($u->email_login())
        {
            json_success(array('loggedin' => true));
        }
        else
        {
            json_success(array('loggedin' => false));
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */