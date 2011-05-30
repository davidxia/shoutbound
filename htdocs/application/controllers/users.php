<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{

    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        if ($u->get_logged_in_user())
        {
            $this->user = $u;
        }
		}
 

    public function logout()
    {
        $this->user->logout();
        redirect('/');
    }
                

    public function ajax_get_logged_in_user()
    {
        if ($this->user)
        {
            json_success(array('loggedin' => (int) $this->user->id));
        }
        else
        {
            json_success(array('loggedin' => 0));        
        }
    }
    
    
    public function login_signup()
    {
        $data = array(
            'callback' => $this->input->post('callback'),
            'id' => $this->input->post('id'),
            'param' => $this->input->post('param'),
        );

        $render_string = $this->load->view('login_signup', $data, TRUE);
        json_success(array('data' => $render_string));
    }
    
    
    public function ajax_change_header()
    {
        $data = array('user' => $this->user);
        $this->load->view('header', $data);
    }


    public function mytest()
    {
        $this->load->library('facebook');
        // get this user's Facebook friends from Facebook
        $fbdata = $this->facebook->api('/me?fields=friends');
        echo '<pre>';print_r($fbdata);echo '</pre>';        
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */