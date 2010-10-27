<?php

class Landing extends Controller {

    function index() {
        $user = $this->User_m->get_logged_in_user();
        if($user)
            redirect('/profile/details');

        else{
            $this->load->view('landing', $view_data);
        }
    }

}

