<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index()
    {
        $user = new User_m();
        $user->logout();
        redirect('/');
    }
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */