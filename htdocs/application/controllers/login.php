<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();        
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            redirect('/home');
        }
    }
    

    public function index()
    {
        $this->load->view('login');    
    }
    
    
    public function ajax_email_login()
    {
        $u = new User_m();
        $user_id = $u->verify_email_pw($this->input->post('email'), $this->input->post('password'));
        if ($user_id)
        {
            $u->get_by_id($user_id);
            if ($u->login())
            {
                $data = array('str' => json_success(array('loggedin' => TRUE)));
            }
        }
        else
        {
            $data = array('str' => json_success(array('loggedin' => FALSE)));
        }
        
        $this->load->view('blank', $data);
    }


    public function ajax_facebook_login()
    {
        $this->load->library('facebook');
        $fbid = $this->facebook->getUser();
        if ($fbid)
        {
            $u = new User_m();
            $u->get_by_fid($fbid);
            if ($u->id)
            {            
                $u->login();
                $data = array('str' => json_success(array('redirect' => site_url('home'), 'existingUser' => TRUE)));
            }
            else
            {
                $data = array('str' => json_success(array('existingUser' => FALSE)));
            }
        }
        
        $this->load->view('blank', $data);
    }
    
    
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */