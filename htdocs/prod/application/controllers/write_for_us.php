<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Write_for_us extends CI_Controller
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
        $this->load->view('write_for_us', $data);
    }
}

/* End of file write_for_us.php */
/* Location: ./application/controllers/write_for_us.php */