<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_account extends CI_Controller
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
            if ($this->user->onboarding_step)
            {
                redirect('/signup/step/'.$this->user->onboarding_step);
            }
        }
        else
        {
            redirect('/');
        }
		}
		

    public function index()
    {
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('my_account/index', $data);
    }


    public function settings()
    {
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('my_account/settings', $data);
    }


    public function invite()
    {
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('my_account/invite', $data);
    }
}

/* End of file my_account.php */
/* Location: ./application/controllers/my_account.php */