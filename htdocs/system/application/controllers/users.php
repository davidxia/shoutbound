<?php

class Users extends Controller
{
 
    function Users()
    {
        parent::Controller();        
    }
 
    function index()
    {
        $this->load->view('facebook_test');
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
    
    
    function ajax_create_fb_user()
    {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,email,friends');
        if ( ! $fbuser)
        {
            json_success(array('error' => true, 'message' => 'We could not get your Facebook data'));
        }
        
        $u = new User();
        if ($u->get_by_fid($fbuser['id'])->id)
        {
            json_success(array('error' => true, 'message' => 'You are already a user'));
        }

        if ( ! $fbuser['email'])
        {
            json_success(array('error' => true, 'message' => 'We could not get your email address'));
        }
        
        $u->clear();
        $u->fid = $fbuser['id'];
        $u->name = $fbuser['name'];
        $u->email = $fbuser['email'];
        
        if ($u->save())
        {
            $u->login($u->id);
            
            // if row exists for this fbid in friends table, delete it
            // corresponding rows in friends_users table auto deleted by DMZ ORM
            $f = new Friend();
            $f->where('facebook_id', $fbuser['id'])->get();
            if ($f->id)
            {
                $f->delete();
            }

            $other_user = new User();
            foreach ($fbuser['friends']['data'] as $friend)
            {
                // check if friend is already Shoutbound user
                // if so save self-relation in related_users_users table
                $other_user->get_by_fid($friend['id']);
                if ($other_user->id)
                {
                    $u->save_related_user($other_user);
                }
                else
                {
                    // check if this friend already exists in friends table
                    // if so, add relation in friends_users table
                    // if not, add new row in friends table
                    $f->where('facebook_id', $friend['id'])->get();
                    if ($f->id)
                    {
                        $u->save($f);
                    }
                    else
                    {
                        $f->clear();
                        $f->facebook_id = $friend['id'];
                        $f->name = $friend['name'];
                        if ($f->save())
                        {
                            $u->save($f);
                        }
                    }
                }
            }
            
            json_success(array('error' => false, 'redirect' => site_url('/')));
        }
        else
        {
            json_success(array('error' => true, 'message' => 'Something went wrong. Please try again.'));
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