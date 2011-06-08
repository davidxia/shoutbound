<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller
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
		

    public function index()
    {
        $data = array('user' => $this->user);
        $this->load->view('about/index', $data);
    }


    public function story()
    {
        $data = array('user' => $this->user);
        $this->load->view('about/story', $data);
    }


    public function team()
    {
        $data = array('user' => $this->user);    
        $this->load->view('about/team', $data);
    }


    public function values()
    {
        $data = array('user' => $this->user);
        $this->load->view('about/values', $data);
    }


}

/* End of file about.php */
/* Location: ./application/controllers/about.php */