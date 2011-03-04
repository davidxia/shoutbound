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
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */