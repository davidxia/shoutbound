<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
{

    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();        
        if ($u->get_logged_in_status())
        {
            redirect('/home');
        }
		}


    function index()
    {
        $view_data = array('is_landing' => 1);
        $this->load->view('landing', $view_data);
    }

}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */