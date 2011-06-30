<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tips extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('tips');
    }
}

/* End of file tips.php */
/* Location: ./application/controllers/tips.php */