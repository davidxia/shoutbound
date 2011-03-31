<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
{
 
    function __construct()
    {
        parent::__construct();
    }


  	function error_404()
  	{
        $this->output->set_status_header('404');
        $this->load->view('404');
  	}
}


/* End of file error.php */
/* Location: ./application/controllers/error.php */