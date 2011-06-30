<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Write_for_us extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('write_for_us');
    }
}

/* End of file write_for_us.php */
/* Location: ./application/controllers/write_for_us.php */