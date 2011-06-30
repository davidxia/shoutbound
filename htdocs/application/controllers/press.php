<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Press extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('press');
    }
}

/* End of file press.php */
/* Location: ./application/controllers/press.php */