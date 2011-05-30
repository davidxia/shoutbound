<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();        
        $u = new User_m();
        if ($u->get_logged_in_user())
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
        if ($u->verify_email_pw($this->input->post('email'), $this->input->post('password')))
        {
            json_success(array('loggedin' => TRUE));
        }
        else
        {
            json_success(array('loggedin' => FALSE));
        }
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
                $this->output->set_output(json_success(array('redirect' => site_url('home'), 'existingUser' => TRUE)));
            }
            else
            {
                $this->output->set_output(json_success(array('existingUser' => FALSE)));
            }
        }
    }
    
    
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */