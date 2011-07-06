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
                $this->load->library('session');
                $returnto = $this->session->flashdata('returnto');
                if ($returnto)
                {
                    $this->session->sess_destroy();
                    redirect('/'.$returnto);
                }
                else if ($user->onboarding_step)
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
    
    
    public function pw_reset()
    {
        if ($this->user)
        {
            redirect('/');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = $this->input->post('email');
            $user = new User_m();
            $user->get_by_email($email);
            if ($user->id AND $user->set_pw_reset())
            {
                $params = array(
                    'email_type' => 80,
                    'user' => $user,
                );
                $this->load->library('sendgrid', $params);
                $this->sendgrid->get_emails();
                $this->sendgrid->compose_email($user);
                $r = $this->sendgrid->send_email();
            }
            json_success(array(
                'message' => 'A password request email has been sent '.
                    'to the address you provided. If an email doesn&rsquo;t '.
                    'arrive shortly, please check your spam folder. '.
                    'If no email arrives, then no account exists with '.
                    'the email you provided.',
            ));
        }
        else
        {
            $this->load->view('pw_reset');
        }
    }
    
    
    public function reset_pw($user_id = NULL, $hash = NULL)
    {
        if ($this->user)
        {
            $this->user->logout();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $user_id = $this->input->post('user_id');
            $hash = $this->input->post('hash');
            $password = $this->input->post('password');
            $password_confirm = $this->input->post('password_confirm');
            
            $user = new User_m();
            if ($user->claim_pw_reset($user_id, $hash)
                AND $password==$password_confirm
                AND $user->get_by_id($user_id)->set_password($password))
            {
                $user->login();
                json_success(array('redirect' => site_url()));
            }
            else
            {
                json_error('The password reset link you used is invalid.');
            }
        }
        else
        {
            $data = array(
                'user_id' => $user_id,
                'hash' => $hash,
            );
            $this->load->view('reset_pw', $data);
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */