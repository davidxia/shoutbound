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
        $this->user->logout();
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
        $this->load->view('header', $data);
    }


}

/* End of file users.php */
/* Location: ./application/controllers/users.php */