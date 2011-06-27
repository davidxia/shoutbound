<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
{

    public function index()
    {
      	$this->load->view('landing');
    }
    
    
    public function test()
    {
        print_r($this->mc->get_stats());
    }
}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */