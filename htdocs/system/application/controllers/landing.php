<?php

class Landing extends Controller {

    function index() {
        $uid = $this->User_m->get_logged_in_uid();
        if($uid)
            redirect('/home');

        else{
            $this->load->view('landing');
        }
    }

}

