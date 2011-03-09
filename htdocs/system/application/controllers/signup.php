<?php

class Signup extends Controller {

    function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
            
        $this->load->view('signup');
    }
    
    
    function create_user()
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
    
    function ajax_create_user()
    {
		    $u = new User();
		    $u->name = $this->input->post('name');
		    $u->email = $this->input->post('email');
		    $u->password = md5('davidxia'.$this->input->post('password').'isgodamongmen');
		    		    
        if ($u->save())
        {
            $u->login($u->id);
            json_success();
        }
        else
        {
            json_error();
        }
    }

}