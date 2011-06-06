<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
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
 

    public function logout()
    {
        if ($this->user)
        {
            $this->user->logout();
        }
        redirect('/');
    }
                

    public function ajax_get_logged_in_user()
    {
        if ($this->user)
        {
            $data = array('str' => json_success(array('loggedin' => $this->user->id)));
        }
        else
        {
            $data = array('str' => json_success(array('loggedin' => 0)));
        }
        $this->load->view('blank', $data);
    }
    
    
    public function login_signup()
    {
        $data = array(
            'callback' => $this->input->post('callback'),
            'id' => $this->input->post('id'),
            'param' => $this->input->post('param'),
        );

        $render_string = $this->load->view('login_signup', $data, TRUE);
        $data = array('str' => json_success(array('data' => $render_string)));
        $this->load->view('blank', $data);
    }
    
    
    public function ajax_change_header()
    {
        $data = array('user' => $this->user);
        $this->load->view('templates/header', $data);
    }

    
    public function check_username_avail()
    {
        $username = strtolower(trim($this->input->post('username')));
        if ( !$username OR !$this->user)
        {
            return FALSE;
        }
        
        if (preg_match('/^[0-9a-zA-Z]+$/', $username))
        {
            $user = new User_m();
            $user->get_by_username($username);
            $reserved_urls = array('login','signup','about','press','contact','home','posts','users','settings','trip_shares','error','profile','trips','places','landing','media','follow','followers','following','shoutbound');
            if (in_array($username, $reserved_urls) OR (isset($user->id) AND $this->user->id != $user->id) OR strlen($username)<4)
            {
                $data = array('str' => json_error('Sorry, that\'s taken :('));
            }
            elseif (isset($user->id) AND $this->user->id == $user->id)
            {
                $data = array('str' => json_success(array('message' => 'That\'s you!')));
            }
            else
            {
                $data = array('str' => json_success(array('message' => 'Available!')));
            }
            
        }
        else
        {
            $data = array('str' => json_error('Only use letters, numbers, and \'_\''));
        }
        $this->load->view('blank', $data);
    }


    public function ajax_save_profile()
    {
        $username = strtolower(trim($this->input->post('username')));
        $bio = trim($this->input->post('bio'));
        $website = strtolower(trim($this->input->post('website')));
        $curr_place_id = $this->input->post('currPlaceId');
        $changes_made = FALSE;
        
        $user = new User_m();
        $user->get_by_username($username);
        $reserved_urls = array('login','signup','about','press','contact','home','posts','users','settings','trip_shares','error','profile','trips','places','landing','media','follow','followers','following','shoutbound');

        if ($user->id OR in_array($username, $reserved_urls) OR strlen($username)<4)
        {
            $username = $this->user->username;
        }
                
        $this->load->model('Activity_m');
        $a = new Activity_m();
        if ($username != $this->user->username OR $bio != $this->user->bio OR $website != $this->user->website)
        {
            $old_bio = $this->user->bio;
            $success = $this->user->set_profile_info(array('username' => $username, 'bio' => $bio, 'website' => $website));
            if ($success AND $bio != $old_bio)
            {
                $a->create(array('user_id' => $this->user->id, 'activity_type' => 9, 'source_id' => 1));
            }
            $changes_made = TRUE;
        }
        
        $this->user->get_current_place();
        if ((!isset($this->user->current_place) AND $curr_place_id) OR ($this->user->current_place AND $curr_place_id AND $this->user->current_place->id != $curr_place_id))
        {
            $success = $this->user->set_current_place_by_place_id($curr_place_id);
            if ($success == 1 OR $success == 2)
            {
                $this->user->get_current_place();
                $a->create(array('user_id' => $this->user->id, 'activity_type' => 10, 'source_id' => $curr_place_id));
                $this->mc->delete('recent_activity_ids_by_user_id:'.$this->user->id);
            }
            
            $params = array('setting_id' => 10, 'user' => $this->user);
            $this->load->library('email_notifs', $params);
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $this->user->current_place);
            $this->email_notifs->send_email();
            
            $changes_made = TRUE;
        }

        if ($changes_made)
        {
            $data = array('str' => json_success(array(
                'changed' => 1,
                'username' => $username,
                'bio' => $bio,
                'website' => $website,
                'response' => 'saved',
            )));
        }
        else
        {
            $data = array('str' => json_error());
        }
        
        $this->load->view('blank', $data);
    }
    
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */