<?php

class Landing extends Controller {

    function index() {
        $who_loves_nan = array('Ben', 'Julianne', 'New York');

        $view_data = array('who_loves_nan' => $who_loves_nan);
        $this->load->view('landing', $view_data);
    }

    function a_new_method() {
        echo 'bai';
    }
}

