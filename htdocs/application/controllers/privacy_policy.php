<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy_policy extends CI_Controller
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
        $this->load->view('privacy_policy', $data);
    }
}

/* End of file privacy_policy.php */
/* Location: ./application/controllers/privacy_policy.php */