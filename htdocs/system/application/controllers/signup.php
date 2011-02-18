<?php

class Signup extends Controller {

    function index() {
        $uid = $this->User_m->get_logged_in_uid();
        if($uid)
            redirect('/home');
            
        $this->load->helper('form');
        $this->load->view('signup');

    }
    
    
    function create_user()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup');
		}
		
		else
		{			
			
			if($uid = $this->User_m->create_user_through_signup())
			{
				echo 'yay signup successful '.$uid;
			}
			else
			{
				$this->load->view('signup');			
			}
		}
		
	}

}