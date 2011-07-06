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
        }
        else if ($this->uri->segment(2) != 'unsubscribe')
        {
            $this->load->library('session');
            $this->session->set_flashdata('returnto', $this->uri->segment(1).'/'.$this->uri->segment(2));
            redirect('/login');
        }
		}
		

    public function index()
    {
        if ($this->user->onboarding_step)
        {
            redirect('/signup/step/'.$this->user->onboarding_step);
        }
        
        $this->user->get_favorites();
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
    
    
    public function unsubscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->user->get_email();
            $data = array(
                'user' => $this->user,
            );
            $this->load->view('my_account/unsubscribe', $data);
        }
        else if ($this->user->set_active(0))
        {
            redirect('/my_account/resubscribe');
        }
    }
    
    
    public function resubscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->user->get_email();
            $data = array(
                'user' => $this->user,
            );
            $this->load->view('my_account/resubscribe', $data);
        }
        else if ($this->user->set_active(1))
        {
            redirect('/');
        }
    }

/*
    public function unsubscribe($user_id=NULL, $created=NULL)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            if ( ! $this->user AND $user_id)
            {
                $this->user = new User_m($user_id);
            }
            else if ( ! $this->user AND ! $user_id)
            {
                custom_404();
                return;
            }
            
            $this->user->get_email();
            $data = array(
                'user' => $this->user,
            );
            $this->load->view('my_account/unsubscribe', $data);
        }
        else if ($user_id AND $created)
        {
            
        }
        else
        {
            
        }
    }
*/
}

/* End of file my_account.php */
/* Location: ./application/controllers/my_account.php */