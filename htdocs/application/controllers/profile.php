<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
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
  	
  	
		public function mytest()
		{
		    $user_id = 1;
		    $p = new User_m(1);
        $p->get_following_users($user_id);
        $p->get_following_trips($user_id);
        $p->get_following_places($user_id);
        
		    $str = '<pre>'.print_r($p, TRUE).'</pre>';
		    $data = array('str' => $str);
		    $this->load->view('blank', $data);
		}
		

    public function index($pid = NULL)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user)))
        {
            custom_404();
            return;
        }

        $profile = new User_m();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $pid = $this->user->id;
            $profile->get_by_id($pid);
            $is_self = TRUE;
            $is_following = FALSE;
        }
        elseif ( ! isset($this->user))
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                custom_404();
                return;
            }
            $is_self = FALSE;
            $is_following = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                custom_404();
                return;
            }
            
            // if profile is not user's own, check if he's following this other user
            if ($pid != $this->user->id)
            {
                $is_self = FALSE;
                $profile->get_follow_status_by_user_id($this->user->id);
                if ($profile->is_following == 1)
                {
                    $is_following = TRUE;
                }
                else
                {
                    $is_following = FALSE;
                }
            }
            else
            {
                $is_self = TRUE;
                $is_following = FALSE;
            }
        }
        
        $profile->get_recent_activity()
          ->get_num_rsvp_yes_trips()
          ->get_num_posts()
          ->get_num_following_users()
          ->get_num_following_trips()
          ->get_num_following_places()
          ->get_num_followers()
          ->get_first_name();
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
            'is_self' => $is_self,
            'is_following' => $is_following,
        );

        $this->load->view('profile/index', $data);
    }


    public function trail($pid = NULL)
    {
        // if user not logged in and no profile specified, return nothing
        if ( ! ($pid OR isset($this->user)))
        {
            return;
        }

        $profile = new User_m();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $pid = $this->user->id;
            $profile->get_by_id($pid);
            $is_self = TRUE;
        }
        elseif ( ! isset($this->user))
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }
            $is_self = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }

            $is_self = ($pid == $this->user->id) ? TRUE : FALSE;
        }
        
        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $profile->get_rsvp_yes_trips($user_id)
          ->get_future_places()
          ->get_current_place()
          ->get_past_places()
          ->get_first_name();

          
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
            'is_self' => $is_self,
        );

        $this->load->view('profile/trail', $data);
    }


    public function posts($pid = NULL)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user)))
        {
            return;
        }

        $profile = new User_m();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $pid = $this->user->id;
            $profile->get_by_id($pid);
        }
        elseif ( ! isset($this->user))
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }
        }
        // if profile specified and user's logged in
        else
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }
        }
        
        if (isset($this->user))
        {
            $this->user->get_rsvp_yes_trips();
            $this->user->get_rsvp_awaiting_trips();
            $this->user->get_following_trips();
        }
        $profile->get_posts();
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
        );
        $this->load->view('profile/posts', $data);
    }
    

    public function following($pid = NULL)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user)))
        {
            return;
        }

        $profile = new User_m();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $pid = $this->user->id;
            $profile->get_by_id($pid);
        }
        elseif ( ! isset($this->user))
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }
        }
        // if profile specified and user's logged in
        else
        {
            $profile->get_by_id($pid);
            if ( ! $profile->id)
            {
                return;
            }
        }
        
        $user_id = (isset($this->user)) ? $this->user->id : NULL;
        $profile->get_following_users($user_id);
        $profile->get_following_trips($user_id);
        $profile->get_following_places($user_id);
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
        );

        $this->load->view('profile/following', $data);
    }
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */