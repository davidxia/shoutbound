<?php

class Error extends Controller
{
 
  	function error_404()
  	{
        $CI =& get_instance();
        $CI->output->set_status_header('404');
        $CI->load->view('404');
  	}

}


/* End of file error.php */
/* Location: ./application/controllers/error.php */