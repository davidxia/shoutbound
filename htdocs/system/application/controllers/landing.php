<?php

class Landing extends Controller {

    function index()
    {
        $u = new User();
        $u->get_logged_in_uid();
        
        if ($u->is_loggedin)
        {
            redirect('/home');
        }
        else
        {
            $this->load->view('landing');
        }
        
    }

}