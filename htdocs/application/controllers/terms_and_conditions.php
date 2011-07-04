<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_and_conditions extends CI_Controller
{
    
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
		}
		

    public function index()
    {
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('terms_and_conditions', $data);
    }
}

/* End of file terms_and_conditions.php */
/* Location: ./application/controllers/terms_and_conditions.php */