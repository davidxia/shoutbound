<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller
{
    
    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u;
        }
        else
        {
            custom_404();
            return;
        }
    }
    
    
    public function edit()
    {
        $this->user->get_followers();
        $this->user->get_following();

        $view_data = array(
            'user' => $this->user->stored,
        );

        $this->load->view('friends', $view_data);
        //print_r($this->user->stored);
    }
    
    
    public function mytest()
    {
        $this->user->get_following();
        print_r($this->user->stored);
    }
    
    
    public function ajax_add_friend()
    {
        $fid = $this->input->post('friendId');
        $f = new User();
        $f->get_by_id($fid);
        
        if ($f->save($this->user))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    
    
    function ajax_accept_request()
    {
        $fid = $this->input->post('friendId');
        $f = new User();
        $f->get_by_id($fid);

        if ($f->save($this->user))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }

}

/* End of file friends.php */
/* Location: ./application/controllers/friends.php */