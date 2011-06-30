<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertise extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('advertise');
    }
}

/* End of file advertise.php */
/* Location: ./application/controllers/advertise.php */