<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{
    private $user;
    
    function __construct()
    {
      	parent::__construct();
        $u = new User();
        if ($u->get_logged_in_status())
        {
            $this->user = $u;
        }
    }


    public function index()
    {
        if ($this->user)
        {
            redirect('/');
        }
        $this->load->view('signup/index');
    }
    
        
    public function create_user()
    {
        if ($this->user OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');
        }

		    $u = new User();
		    $u->name = $this->input->post('name');
		    $u->email = $this->input->post('email');
		    $u->password = md5('davidxia'.$this->input->post('password').'isgodamongmen');
		    $u->created = time()-72;
		    		    
        if ($this->input->post('is_fb_signup'))
        {
            $this->load->library('facebook');
            $fbuser = $this->facebook->api('/me?fields=name,friends,picture');
            $u->fid = $fbuser['id'];
        }
        else
        {
    		    $n = mt_rand(1, 8);
    		    $u->profile_pic = 'default_avatar'.$n.'.png';
        }

        if ($u->save())
        {
            $u->login($u->id);
            if ($this->input->post('is_fb_signup'))
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
                        foreach ($auto_follow->trip->where('is_active', 1)->where_join_field('user', 'role >=', 5)->get_iterated() as $trip)
                        {
                            $u->save($trip);
                            $u->set_join_field($trip, 'rsvp', 3);
                            $u->set_join_field($trip, 'role', 0);
                        }
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
                
                $this->load->helper('avatar');
                $file_name = save_fb_photo($u->id, $fbuser['id'], 'large');
                if ($file_name)
                {
                    $u->profile_pic = $file_name;
                    $u->save();
                }
            }
            redirect('signup/onboarding');
        }
        else
        {
            $this->load->view('signup/index');
        }
    }
    
    
    public function ajax_create_user()
    {
        if ($this->user OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');
        }
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
        if ($this->user OR getenv('REQUEST_METHOD') == 'GET')
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
    
    
    public function dream()
    {
        if ( ! $this->user)
        {
            redirect('/');
        }

        $data = array(
        );
        $this->load->view('signup/dream');
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
        if ( ! $this->user)
        {
            redirect('/');
        }
        
        // we auto followed their friends
        $this->user->get_following();
        $this->user->get_num_following();
        $this->user->get_num_following_trips();
        $this->user->get_num_following_places();
        
        $data = array(
            'user' => $this->user->stored,
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
        $this->user->get_following_trips();
        
        $data = array(
            'user' => $this->user->stored,
        );
        $this->load->view('signup/trips', $data);
    }
    
    
    public function places()
    {
        if ( ! $this->user)
        {
            redirect('/');
        }
        
        // we auto followed their bucket list
        $this->user->get_following_places($this->user->id);
        
        $data = array(
            'user' => $this->user->stored,
        );
        $this->load->view('signup/places', $data);
    }


    public function profile()
    {
        if ( ! $this->user)
        {
            redirect('/');
        }

        $data = array(
            'user' => $this->user->stored,
        );
        $this->load->view('signup/profile', $data);
    }
}


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */