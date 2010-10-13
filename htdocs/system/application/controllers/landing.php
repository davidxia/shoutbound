<?php

class Landing extends Controller {

    function index() {
        $uid = $this->User_m->get_current_logged_in_uid();
        if($uid)
            redirect('/trip');

        $this->load->view('landing', $view_data);
    }

}

