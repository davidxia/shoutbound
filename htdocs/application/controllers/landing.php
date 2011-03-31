<?php

class Landing extends CI_Controller
{

    function __construct()
    {
    	  parent::__construct();
    }


    function index()
    {
        $u = new User();        
        if ($u->get_logged_in_status())
        {
            redirect('/home');
        }
        else
        {
            $view_data = array('is_landing' => 1);
            $this->load->view('landing', $view_data);
        }
    }

}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */