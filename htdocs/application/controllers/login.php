<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            redirect('/');
        }
		}


    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->load->view('login');
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = new User_m();
            $user_id = $user->verify_email_password($email, $password);
            if ($user_id)
            {
                $user->get_by_id($user_id)->login();
                if ($user->onboarding_step)
                {
                    redirect('/signup/step/'.$user->onboarding_step);
                }
                else
                {
                    redirect('/');
                }
            }
            else
            {
                $data = array(
                    'invalid_login' => TRUE,
                );
                $this->load->view('login', $data);
            }
        }
        else
        {
            custom_404();
            return;
        }

    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */

