<?php

class Landing extends Controller {

    function index() {
        $uid = $this->User_m->get_logged_in_uid();
        if($uid)
            redirect('/profile/details');

        else{
            $this->load->view('landing');
        }
    }

}

