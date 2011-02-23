<?php
class Users extends Controller {
 
    function Users()
    {
        parent::Controller();        
    }
 
    function index()
    {         
        $u = new User();
        if ($u->get_logged_in_status())
        {
            $u->get_by_fid(122703);
            print_r($u->name);
        }
        else
        {
            echo 'no cookie :(';
        }

    }
    
    function logout()
    {
        $u = new User();
        $u->logout();
        redirect('/');
    }
    
    function ajax_login()
    {
        $this->load->library('facebook');
        $u = new User();
        $u->get_by_fid($this->facebook->getUser());
        
        if ( ! empty($u->id))
        {
            $u->login($u->id);
            json_success(array('redirect' => site_url('home')));
        }
        else
        {
            json_success(array('redirect' => site_url('users/creating')));
        }
    }
    
    
    function creating()
    {
        $this->load->library('facebook');
        $session = $this->facebook->getSession();
        $u = new User();
        
        if ( ! $session)
        {
            //redirect('/landing');
            echo 'youre not in fb!';
        }
        else
        {
            echo 'youre in fb';
        }
        
        if ($u->get_by_fid($this->facebook->getUser()))
        {
            //redirect('/');
            echo 'this fid already exists!';
        }
        //$this->load->view('creating_user');

    }
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */