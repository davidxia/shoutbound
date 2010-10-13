<?php

class User extends Controller {

    function ajax_login() {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        if(!$session) {
            json_error('You must be logged in to Facebook to log in to noqnok');
            return;
        }

        $user = $this->User_m->get_user_by_fid($this->facebook->getUser());
        if($user) {
            json_success(array('redirect' => site_url('trip')));
        } else {
            json_success(array('redirect' => site_url('user/creating')));
        }
    }


    function creating() {
        echo 'creating user!';
    }

}

