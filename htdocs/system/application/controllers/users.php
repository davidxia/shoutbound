<?php

class Users extends Controller {
 
    function Users()
    {
        parent::Controller();        
    }
 
    function index()
    {         
    }
    
    function logout()
    {
        $u = new User();
        $u->logout();
        redirect('/');
    }
    
    function login()
    {
        $u = new User();

        $u->email = $this->input->post('email');
        $u->password = $this->input->post('password');

        if ($u->email_login())
        {
            redirect('/');
        }
        else
        {
            // Show the custom login error message
            echo '<p>invalid password or email</p>';
        }
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


    function ajax_login()
    {
        $this->load->library('facebook');
        $u = new User();
        $u->get_by_fid($this->facebook->getUser());
        
        if (empty($u->id))
        {
            json_success(array('redirect' => site_url('users/creating'), 'existingUser' => false));
        }
        else
        {
            $u->login($u->id);
            json_success(array('redirect' => site_url('home'), 'existingUser' => true));
        }
    }
    
    
    function creating()
    {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        $u = new User();
        
        if ( ! $session)
        {
            redirect('/landing');
        }
                
        if ($u->get_by_fid($this->facebook->getUser())->id)
        {
            redirect('/');
        }
        
        $this->load->view('creating_user');
    }
    
    
    function ajax_create_user()
    {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,email,friends');
        $u = new User();

        if ( ! $fbuser)
        {
            json_success(array('error' => true, 'message' => 'We could not get your Facebook data'));
        }
        
        if ($u->get_by_fid($fbuser['id'])->id)
        {
            json_success(array('error' => true, 'message' => 'You are already a user'));
        }

        $udata = array('fid' => $fbuser['id'],
                       'name' => $fbuser['name']);

        if ( ! $fbuser['email'])
        {
            json_success(array('error' => true, 'message' => 'We could not get your email address'));
        }
        $udata['email'] = $fbuser['email'];
        
        $u->clear();
        $u->fid = $fbuser['id'];
        $u->name = $fbuser['name'];
        $u->email = $fbuser['email'];
        if ($u->save())
        {
            $u->login($u->id);
        }
        
        $f = new Friend();
        foreach ($fbuser['friends']['data'] as $friend)
        {
            $f->clear();
            $f->friend_fid = $friend['id'];
            $f->name = $friend['name'];
            if ($f->save())
            {
                $u->save($f);
            }
        }
        
        json_success(array('error' => false, 'redirect' => site_url('/')));
        
    }


    function ajax_get_logged_in_status()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        
        if ($uid)
        {
            json_success(array('loggedin'=>$uid));
        }
        else
        {
            json_success(array('loggedin'=>FALSE));        
        }
    }
    
    
    function login_signup()
    {
        $render_string = $this->load->view('login_signup', $view_data, true);
        json_success(array('data'=>$render_string));
    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */