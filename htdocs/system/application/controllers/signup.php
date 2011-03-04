<?php

class Signup extends Controller {

    function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
            
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
    		
    		
    		if ($this->form_validation->run() == FALSE)
    		{
    			$this->load->view('signup');
    		}
    		else
    		{
    		    $u = new User();
    		    $u->name = $this->input->post('name');
    		    $u->email = $this->input->post('email');
    		    $u->password = md5('davidxia'.$this->input->post('password').'isgodamongmen');
    		    
            if ($u->save())
            {
                $u->login($u->id);
                redirect('/');
            }
            else
            {
                $this->load->view('signup');			
            }
		}
		
	}

}