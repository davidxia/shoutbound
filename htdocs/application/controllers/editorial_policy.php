<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editorial_policy extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('editorial_policy');
    }
}

/* End of file editorial_policy.php */
/* Location: ./application/controllers/editorial_policy.php */