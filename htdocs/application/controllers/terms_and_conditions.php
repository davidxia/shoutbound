<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_and_conditions extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('terms_and_conditions');
    }
}

/* End of file terms_and_conditions.php */
/* Location: ./application/controllers/terms_and_conditions.php */