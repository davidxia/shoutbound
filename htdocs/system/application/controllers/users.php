<?php
class Users extends Controller {
 
    function Users()
    {
        parent::Controller();
    }
 
    function index()
    {         
        $u = new User();
        $u->get_by_fid(122703);
        print_r($u->name);
    }
    
    function logout()
    {
        $this->User->logout();
        redirect('/');
    }
    
    function ajax_login()
    {
        $this->load->library('facebook');
        $u = new User();
        $u->get_by_fid($this->facebook->getUser());
        
        if( ! empty($u->id))
        {
            $u->login($u->id);
            json_success(array('redirect' => site_url('home')));
        }
        else
        {
            json_success(array('redirect' => site_url('user/creating')));
        }
    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */