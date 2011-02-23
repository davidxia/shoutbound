<?php

class Landing extends Controller {

    function index()
    {
        $u = new User();        
        if ($u->get_logged_in_status())
        {
            redirect('/home');
        }
        else
        {
            $this->load->view('landing');
        }
    }

}