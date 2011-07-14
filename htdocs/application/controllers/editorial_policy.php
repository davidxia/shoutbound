<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editorial_policy extends CI_Controller
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
        $this->load->view('editorial_policy', $data);
    }
}

/* End of file editorial_policy.php */
/* Location: ./application/controllers/editorial_policy.php */