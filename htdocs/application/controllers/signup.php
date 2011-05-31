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
            $file_name = save_fb_photo($user->id, $fbuser['id'], 'large');
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
		    		    

        if ($success)
        {
            $user->login($user->id);
            if ($this->input->post('is_fb_signup'))
            {


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
                        $auto_follow->get_trips();
                        
                        foreach ($auto_follow->trips as $trip)
                        {
                            $user->set_rsvp_role_for_trip_id($trip->id, 3, 0);
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
            redirect('signup/dream');
        }
        else
        {
            $this->load->view('signup/index');
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
            $file_name = save_fb_photo($user->id, $fbuser['id'], 'large');
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
    

    public function ajax_get_fb_info()
    {
        if ($this->user)
        {
            redirect('/');
        }

        $this->load->library('facebook');
        $fbuser = $this->facebook->api('/me?fields=name,email');
        
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
*/
    
    
    public function dream()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            redirect('/');
        }
        
        $this->user->get_future_places();

        $data = array(
            'user' => $this->user->stored,
            'is_onboarding' => TRUE,
        );
        $this->load->view('signup/dream', $data);
    }
    
    
    public function save_bucket_list()
    {
        if ( ! $this->user OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');
        }

        $post = $this->input->post('place');
        $post = $post['place'];
        $p = new Place();
        foreach ($post as $key => $val)
        {
            if (is_array($val))
            {
                $p->clear();
                $p->get_by_id($val['place_id']);
                $is_saved = FALSE;
                if ($this->user->save($p))
                {
                    $this->user->set_join_field($p, 'is_future', 1);
                    $this->user->set_join_field($p, 'is_following', 1);
                    $is_saved = TRUE;
                }
            }
        }
        
        if ($is_saved)
        {
            redirect(site_url('signup/follow'));
        }
        else
        {
            echo 'something broken, tell David';
        }
    }


    public function follow()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            redirect('/');
        }
        
        // we auto followed their friends
        $this->user->get_following();
        // dump all users this user is not following
        $user_ids = array();
        foreach ($this->user->stored->following as $following)
        {
            $user_ids[] = $following->id;
        }
        $u = new User();
        $other_users = array();
        if (empty($user_ids))
        {
            foreach ($u->get_iterated() as $other_user)
            {
                if ($other_user->id != $this->user->id)
                {
                    $other_users[] = $other_user->stored;
                }
            }
        }
        else
        {
            foreach ($u->where_not_in('id', $user_ids)->get_iterated() as $other_user)
            {
                if ($other_user->id != $this->user->id)
                {
                    $other_users[] = $other_user->stored;
                }
            }
        }
        
        $this->user->get_num_following();
        $this->user->get_num_following_trips();
        $this->user->get_num_following_places();
        
        $data = array(
            'user' => $this->user->stored,
            'other_users' => $other_users,
            'is_onboarding' => TRUE,
        );
        $this->load->view('signup/follow', $data);
    }
    
    
    public function trips()
    {
        if ( ! $this->user)
        {
            redirect('/');
        }
        
        // we auto followed their friends' rsvp yes trips
        //$this->user->get_following_trips();
        $t = new Trip();
        $trips = $t->onboarding_trips($this->user->id);
        
        $data = array(
            'user' => $this->user->stored,
            'trips' => $trips,
        );
        $this->load->view('signup/trips', $data);
        //echo '<pre>';print_r($trips);echo '</pre>';
        
    }
    
    
    public function places()
    {
        if ( ! $this->user)
        {
            redirect('/');
        }
        
        // we auto followed their bucket list
        //$this->user->get_following_places($this->user->id);
        $p = new Place();
        $places = $p->onboarding_places($this->user->id);
        
        $data = array(
            'user' => $this->user->stored,
            'places' => $places,
        );
        $this->load->view('signup/places', $data);
    }


    public function profile()
    {
        if ( ! $this->user OR $this->user->is_onboarded)
        {
            redirect('/');
        }

        $this->user->get_current_place();
        $data = array(
            'user' => $this->user->stored,
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
        
        $this->user->is_onboarded = 1;
        if ($this->user->save())
        {
            redirect(site_url('home'));
        }
    }
}


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */