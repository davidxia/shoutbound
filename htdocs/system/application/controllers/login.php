<?php

class Login extends Controller {
 
    function Login()
    {
        parent::Controller();        
    }
    
 
    function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
            
        $this->load->helper('form');
        $this->load->view('login');
    
    }
    
    
    function ajax_email_login()
    {
        $u = new User();
        $u->email = $this->input->post('email');
        $u->password = $this->input->post('password');

        if ($u->email_login())
        {
            json_success(array('loggedin' => true));
        }
        else
        {
            json_success(array('loggedin' => false));
        }
    }


    function ajax_facebook_login()
    {
        $this->load->library('facebook');
        $u = new User();
        $u->get_by_fid($this->facebook->getUser());
        
        if (empty($u->id))
        {
            json_success(array('existingUser' => false));
        }
        else
        {
            $u->login($u->id);
            json_success(array('redirect' => site_url('home'), 'existingUser' => true));
        }
    }


    function ajax_update_fb_friends()
    {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,friends');
        if ($fbuser)
        {
            $u = new User();
            $uid = $u->get_logged_in_status();
            if ( ! $uid)
            {
                redirect('/');            
            }
            $u->get_by_id($uid);
            
            // get user's facebook friends from friends & users table and store in array
            $u->friend->get();
            foreach ($u->friend as $friend)
            {
                $db_fb_friends_fids[] = $friend->facebook_id;
            }
            $u->related_user->get();
            foreach ($u->related_user as $user)
            {
                if ($user->fid)
                {
                    $db_fb_friends_fids[] = $user->fid;
                }
            }
    
            // get user's current facebook friends' fids and store in array
            foreach ($fbuser['friends']['data'] as $friend)
            {
                $fb_friends_fids[] = $friend['id'];
            }
            
            // get current facebook friends not in the db and add them
            $diff = array_diff($fb_friends_fids, $db_fb_friends_fids);
            if (count($diff))
            {
                $f = new Friend();
                foreach ($diff as $key => $val)
                {
                    $f->clear();
                    $f->facebook_id = $val;
                    $f->name = $fbuser['friends']['data'][$key]['name'];
                    if ($f->save())
                    {
                        $u->save($f);
                    }
                }
            }
            
        }
     
        //json_success(array());
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */