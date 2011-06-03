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
        $username = strtolower($this->input->post('username'));
        if (preg_match('/^[0-9a-zA-Z]+$/', $username))
        {
            $user = new User_m();
            $user->get_by_username($username);
            if (isset($user->id))
            {
                $data = array('str' => json_error('Sorry, it\'s been taken :('));
            }
            else
            {
                $data = array('str' => json_success(array('message' => 'Yay, it\'s available!')));
            }
            
        }
        else
        {
            $data = array('str' => json_error('Only use letter, numbers, and \'_\''));
        }
        $this->load->view('blank', $data);
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */