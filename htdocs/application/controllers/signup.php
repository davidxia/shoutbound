<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{

    function __construct()
    {
      	parent::__construct();
    }


    function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
            
        $this->load->view('signup');
    }
    
    
    function create_user()
    {
		    $u = new User();
		    $u->name = $this->input->post('name');
		    $u->email = $this->input->post('email');
		    $u->password = md5('davidxia'.$this->input->post('password').'isgodamongmen');
		    $n = mt_rand(1, 8);
		    $u->profile_pic = 'default_avatar'.$n.'.png';
		    $u->created = time()-72;
		    		    
        if ($u->save())
        {
            $u->login($u->id);
            redirect('/');
        }
        else
        {
            $this->load->view('signup');			
        }
    }
    
    function ajax_create_user()
    {
		    $u = new User();
		    $u->name = $this->input->post('signupName');
		    $u->email = $this->input->post('signupEmail');
		    $u->password = md5('davidxia'.$this->input->post('signupPw').'isgodamongmen');
		    $u->created = time()-72;

        if ($u->save())
        {
            $u->login($u->id);
            json_success();
        }
        else
        {
            json_error();
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
}


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */