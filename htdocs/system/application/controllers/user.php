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
            $this->User_m->log_in($user['uid']);
            json_success(array('redirect' => site_url('trip')));
        } else {
            json_success(array('redirect' => site_url('user/creating')));
        }
    }


    function creating() {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        if(!$session) {
            redirect('/landing');
        }
        if($this->User_m->get_user_by_fid($this->facebook->getUser()))
            redirect('/trip');

        $this->load->view('creating_user');
    }


    function ajax_create_user() {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=email,hometown,friends');
        if(!$fbuser) {
            json_error('We could not get your facebook data!');
        }
        if($this->User_m->get_user_by_fid($fbuser['id']))
            json_error('You are already a user');


        $udata = array('fid' => $fbuser['id']);

        if(!$fbuser['email'])
            return json_error('Couldn\'t get your email address');
        $udata['email'] = $fbuser['email'];

        if($fbuser['hometown']['name'])
            $udata['hometown'] = $fbuser['hometown']['name'];

        $uid = $this->User_m->create_user($udata);
        $this->User_m->log_in($uid);
        foreach($fbuser['friends']['data'] as $friend) {
            $this->User_m->add_friendship($uid, $friend['id']);
        }

        json_success(array('redirect' => site_url('trip')));
    }

}

