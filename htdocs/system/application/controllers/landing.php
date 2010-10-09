<?php

class Landing extends Controller {

    function index() {
        $who_loves_nan = array('Ben', 'Julianne', 'New York');

        $view_data = array('who_loves_nan' => $who_loves_nan);
        $this->load->view('landing', $view_data);
    }

    function logged_in() {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        if(!$session) {
            echo 'You aren\'t logged in! <a href="'.site_url('').'">Go back!</a>';
            return;
        }
        echo 'You are uid: ', $this->facebook->getUser();

    }
}

