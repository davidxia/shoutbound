<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_account extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $this->load->view('my_account/index');
    }


    public function settings()
    {
        $this->load->view('my_account/settings');
    }
}

/* End of file my_account.php */
/* Location: ./application/controllers/my_account.php */