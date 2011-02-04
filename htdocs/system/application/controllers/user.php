<?php

class User extends Controller {

    function logout() {
        $this->User_m->log_out();
        redirect('/');
    }


    function ajax_login() {
        $this->load->library('facebook');
        //$session = $this->facebook->getSession();
        //if(!$session) {
            //json_error('You must be logged in to Facebook to log in to ShoutBound');
            //return;
        //}

        $user = $this->User_m->get_user_by_fid($this->facebook->getUser());
        if($user) {
            $this->User_m->log_in($user['uid']);
            json_success(array('redirect' => site_url('home')));
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
            redirect('/profile/details');

        $this->load->view('creating_user');
    }


    function ajax_create_user() {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,email,hometown,friends');
        if(!$fbuser) {
            json_error('We could not get your facebook data!');
        }
        if($this->User_m->get_user_by_fid($fbuser['id']))
            json_error('You are already a user');


        $udata = array('fid' => $fbuser['id'],
                       'name' => $fbuser['name']);

        if(!$fbuser['email'])
            return json_error('Couldn\'t get your email address');
        $udata['email'] = $fbuser['email'];

        if($fbuser['hometown']['name'])
            $udata['hometown'] = $fbuser['hometown']['name'];

        //FUTURENOTE: Allow user to select home on a map OR geocode his/her udata['hometown']
        $udata['home_lat'] = 40.7144816;
        $udata['home_lon'] = -73.9909809;
        $uid = $this->User_m->create_user($udata);
        $this->User_m->log_in($uid);
        foreach($fbuser['friends']['data'] as $friend) {
            $this->User_m->add_friendship($uid, $friend['id'], $friend['name']);
        }

        json_success(array('redirect' => site_url('home')));
    }
    
    function ajax_update_friends() {
        $this->load->library('facebook');
        $uid = $this->User_m->get_logged_in_uid();
        $fbuser = $this->facebook->api('/me?fields=name,email,hometown,friends');
        foreach($fbuser['friends']['data'] as $friend) {
            echo($friend['id']);
            echo($friend['name']);
            //$this->User_m->add_friendship($uid, $friend['id'], $friend['name']);
            $sql = 'insert into friends (uid, name, friend_fid, friend_uid) '.
                    'values (?,?,?,?) ON DUPLICATE KEY UPDATE friend_uid = ?';
            $friend_uid = 0;
            if($fri = $this->User_m->get_user_by_fid($friend['id']))
                $friend_uid = $fri['uid'];
            $v = array($uid, $friend['name'], $friend['id'], $friend_uid, $friend_uid);
            $this->mdb->alter($sql, $v);

            echo('added friend');
        }
    }


}

