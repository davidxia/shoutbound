<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller
{

    public function index()
    {
      	$session_id = $this->session->userdata('session_id');
      	
      	$data = array(
            'session_id' => $session_id,
      	);

      	$this->load->view('landing', $data);
    }
    
    
}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */