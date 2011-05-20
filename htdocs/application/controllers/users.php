<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
 
    function __construct()
    {
        parent::__construct();        
    }
 

    public function logout()
    {
        $u = new User();
        $u->logout();
        redirect('/');
    }
                

    public function ajax_get_logged_in_status()
    {
        $u = new User();        
        if ($u->get_logged_in_status())
        {
            json_success(array('loggedin'=>$u->id));
        }
        else
        {
            json_success(array('loggedin'=>0));        
        }
    }
    
    
    public function login_signup()
    {
        $view_data = array(
            'callback' => $this->input->post('callback'),
            'id' => $this->input->post('id'),
            'param' => $this->input->post('param'),
        );

        $render_string = $this->load->view('login_signup', $view_data, true);
        json_success(array('data'=>$render_string));
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */