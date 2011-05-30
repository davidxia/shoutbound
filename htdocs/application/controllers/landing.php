<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
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
        $data = array('is_landing' => 1);
        $this->load->view('landing', $data);
    }

}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */