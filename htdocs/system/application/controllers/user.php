<?php

class User extends Controller {

    function ajax_login() {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        if(!$session) {
            json_error('You must be logged in to Facebook to log in to noqnok');
            return;
        }

        $user = $this->User->get_user_by_fid($this->facebook->getUser());
        if($user) {
            echo 'You are a user';
            print_r($user);
        } else {
            echo 'you don\'t exist yet';
        }
    }

}

