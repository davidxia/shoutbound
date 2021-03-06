<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
		}
		
		
    public function index()
    {
        if ($this->user)
        {
            redirect('/home');
        }
        $this->load->view('signup/index');
    }
    
        
    public function create_user()
    {
        $name = trim($this->input->post('signup_name'));
        $email = strtolower(trim($this->input->post('signup_email')));
        $password = $this->input->post('signup_pw');
        $invite_code = $this->input->post('invite_code');
        
        if ($this->user OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        if (strcasecmp($invite_code,'tbex'))
        {
            json_success(array(
                'inviteCode' => 0,
                'message' => 'Shoutbound is currently in private alpha. '.
                    'If you need an invite code, '.
                    '<a href="mailto:hello@shoutbound.com" style="font-weight:bold">e-mail us</a>, '.
                    'and we\'ll contact you when spots open up.',
            ));
            return FALSE;
        }

        if ($this->input->post('is_fb_signup'))
        {
            // save Facebook id
            $this->load->library('facebook');
            $fbdata = $this->facebook->api('/me?fields=name,friends,picture');
            $fid = $fbdata['id'];
        }
        else
        {
            $fid = NULL;
        }
        
		    $user = new User_m();
		    $r = $user->create(array(
		        'name'        => $name,
		        'email'       => $email,
		        'password'    => $password,
		        'fid'         => $fid,
		        'profile_pic' => NULL,
		    ));
		    		    

        if ($r['success'])
        {
            if ($this->input->post('is_fb_signup'))
            {
                // save Facebook profile photo
                $this->load->helper('avatar');
                $file_name = save_fb_photo($user->id, $fbdata['id'], 'large');
                if ($file_name)
                {
                    $user->set_profile_info(array('profile_pic' => $file_name));
                }
                
                $this->load->model('Friend_m');
                $friend = new Friend_m();
                $auto_follow = new User_m();
                foreach ($fbdata['friends']['data'] as $fb_friend)
                {
                    // check if friend is already Shoutbound user
                    // if so auto follow them for new user
                    $auto_follow->get_by_fid($fb_friend['id']);
                    if ($auto_follow->id)
                    {
                        $user->set_follow_for_user_id($auto_follow->id, 1);
                        
                        $this->load->model('Activity_m');
                        $a = new Activity_m();
                        if ($a->create(array('user_id' => $user->id, 'activity_type' => 3, 'source_id' => $auto_follow->id)))
                        {
                            $a->create(array('user_id' => $auto_follow->id, 'activity_type' => 8, 'source_id' => $user->id));
                        }
                        
                        $this->load->library('email_notifs', array('setting_id' => 3, 'profile' => $auto_follow));
                        $this->email_notifs->get_emails();
                        $this->email_notifs->compose_email($user, $auto_follow);
                        $this->email_notifs->send_email();
    
                        $auto_follow->get_trips();
                        
                        foreach ($auto_follow->trips as $trip)
                        {
                            if ($user->set_rsvp_role_for_trip_id($trip->id, 3, 0))
                            {
                                $a->create(array('user_id' => $user->id, 'activity_type' => 4, 'source_id' => $trip->id));
                    
                                $params = array('setting_id' => 4, 'trip' => $trip);
                                $this->load->library('email_notifs', $params);
                                $this->email_notifs->get_emails();
                                $this->email_notifs->compose_email($user, 3, $trip);
                                $this->email_notifs->send_email();
                            }
                        }
                    }
                    else
                    {
                        // check if this friend already exists in friends table
                        // if so, add relation in friends_users table
                        // if not, add new row in friends table
                        $friend->get_by_facebook_id($fb_friend['id']);
                        if ( ! $friend->id)
                        {
                            $friend->create(array('facebook_id' => $fb_friend['id'], 'name' => $fb_friend['name']));
                        }
                        $user->add_friend_by_friend_id($friend->id);
                    }
                }
            }
            $user->login($user->id);
            json_success(array('inviteCode' => 1, 'redirect' => site_url('signup/dream')));
        }
        else
        {
            json_error($r['message']);
        }
    }
    
    
/*
    public function ajax_create_user()
    {
        if ($this->user OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');
        }
        
        if ($this->input->post('is_fb_signup'))
        {
            // save Facebook id
            $this->load->library('facebook');
            $fbdata = $this->facebook->api('/me?fields=name,friends,picture');
            $fid = $fbdata['id'];
            
            // save Facebook profile photo
            $this->load->helper('avatar');
            $file_name = save_fb_photo($user->id, $fbdata['id'], 'large');
        }
        else
        {
            $fid = NULL;
        }
        
		    $user = new User_m();
		    $success = $user->create(array(
		        'name'        => $this->input->post('name'),
		        'email'       => $this->input->post('signup_email'),
		        'password'    => $this->input->post('password'),
		        'fid'         => $fid,
		        'profile_pic' => ($file_name) ? $file_name : NULL,
		    ));

        
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
*/

    public function ajax_get_fb_info()
    {
        if ($this->user)
        {
            redirect('/');
        }

        $this->load->library('facebook');
        $fbdata = $this->facebook->api('/me?fields=name,email');
        
        if ( ! $fbdata)
        {
            json_error('We could not get your Facebook data');
            return FALSE;
        }
        $u = new User_m();
        if ($u->get_by_fid($fbdata['id'])->id)
        {
            json_error('You already have an account.');
            return FALSE;
        }
        else
        {
            json_success(array('name' => $fbdata['name'], 'email' => $fbdata['email']));
        }        
    }
    
    
    public function dream()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            custom_404();
            return;
        }
        
        $this->user->get_future_places();

        $data = array(
            'user' => $this->user,
            'is_onboarding' => TRUE,
        );
        $this->load->view('signup/dream', $data);
    }


    public function follow()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            custom_404();
            return;
        }
        
        // we auto followed their friends
        //$this->user->get_following_users();
        
        $this->user->get_onboarding_users();
        
        $this->user
            ->get_num_following_users()
            ->get_num_following_trips()
            ->get_num_following_places();
        
        $data = array(
            'user' => $this->user,
            'is_onboarding' => TRUE,
        );
        $this->load->view('signup/follow', $data);
    }
    
    
    public function trips()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            custom_404();
            return;
        }
        
        // we auto followed their friends' rsvp yes trips
        //$this->user->get_following_trips();
        
        $this->user->get_onboarding_trips();
        
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('signup/trips', $data);
    }
    
    
    public function places()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            custom_404();
            return;
        }
        
        // we auto followed their bucket list
        //$this->user->get_following_places($this->user->id);
        
        $this->user->get_onboarding_places();

        $data = array(
            'user' => $this->user,
        );
        $this->load->view('signup/places', $data);
    }


    public function profile()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            custom_404();
            return;
        }

        $this->user->get_current_place();
        $data = array(
            'user' => $this->user,
            'is_onboarding' => TRUE,
        );
        $this->load->view('signup/profile', $data);
    }
    
    
    public function finish()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            redirect('/');
        }
        
        if ($this->user->set_onboarding_status(1))
        {
            $this->mc->delete('user_by_user_id:'.$this->user->id);
            redirect('/home');
        }
    }
}


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */