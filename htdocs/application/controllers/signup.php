<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{

    function __construct()
    {
      	parent::__construct();
    }


    public function index()
    {
        $u = new User();
        if ($u->get_logged_in_status())
        {
            redirect('/');
        }
        $this->load->view('signup/index');
    }
    
    
    public function create_user()
    {
		    $u = new User();
		    $u->name = $this->input->post('name');
		    $u->email = $this->input->post('email');
		    $u->password = md5('davidxia'.$this->input->post('password').'isgodamongmen');
		    $n = mt_rand(1, 8);
		    $u->profile_pic = 'default_avatar'.$n.'.png';
		    $u->created = time()-72;
		    		    
        if ($this->input->post('fb_login'))
        {
            $this->load->library('facebook');
            $fbuser = $this->facebook->api('/me?fields=name,friends');
            $u->fid = $fbuser['id'];
        }

        if ($u->save())
        {
            $u->login($u->id);
            if ($this->input->post('fb_login'))
            {
                $f = new Friend();
                $auto_follow = new User();
                foreach ($fbuser['friends']['data'] as $friend)
                {
                    // check if friend is already Shoutbound user
                    // if so auto follow them for new user
                    $auto_follow->get_by_fid($friend['id']);
                    if ($auto_follow->id)
                    {
                        $auto_follow->save($u);
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
            }
            redirect('/');
        }
        else
        {
            $this->load->view('signup/index');			
        }
    }
    
    
    public function ajax_create_user()
    {
		    $u = new User();
		    $u->name = $this->input->post('signupName');
		    $u->email = $this->input->post('signupEmail');
		    $u->password = md5('davidxia'.$this->input->post('signupPw').'isgodamongmen');
		    $n = mt_rand(1, 8);
		    $u->profile_pic = 'default_avatar'.$n.'.png';
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
    

    public function ajax_create_fb_user()
    {
        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,email');
        //$fbuser = $this->facebook->api('/me?fields=name,email,friends');
        
        if ( ! $fbuser)
        {
            json_error('We could not get your Facebook data');
        }
        $u = new User();
        if ($u->get_by_fid($fbuser['id'])->id)
        {
            json_error('You already have an account.');
        }
        else
        {
            json_success(array('name' => $fbuser['name'], 'email' => $fbuser['email']));
        }
    }
    
    
    public function onboarding()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid)
        {
            redirect('/');
        }
        $u->get_by_id($uid);
        // we auto followed their friends
        $u->get_following();
        // we auto followed their friends' rsvp yes trips
        $f = new User();
        foreach ($u->stored->following as $following)
        {
            $f->get_by_id($following->id);
            $f->get_rsvp_yes_trips();
            $following->trips = array();
            foreach ($f->stored->rsvp_yes_trips as $rsvp_yes_trip)
            {
                $following->trips[] = $rsvp_yes_trip;
            }
        }

        $data = array(
            'user' => $u->stored,
        );
        $this->load->view('signup/onboarding', $data);
        //print_r($u->stored);
    }
}


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */