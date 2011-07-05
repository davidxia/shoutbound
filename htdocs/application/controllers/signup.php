<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
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
        if ($this->user)
        {
            if ($this->user->onboarding_step)
            {
                redirect('/signup/step/'.$this->user->onboarding_step);
            }
            else
            {
                redirect('/');
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $this->load->view('signup/index');
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = $this->input->post('signup_email');
            $password = $this->input->post('signup_password');
            
            if (!$email OR !$password)
            {
                json_error('Please enter both e-mail and password.');
                return;
            }
            
            $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i';
            
            if ( ! preg_match($pattern, $email))
            {
                json_error('This is not a valid email.');
                return;
            }
            
            $user = new User_m();
            $params = array(
                'email' => $email,
                'password' => $password,
            );
            $r = $user->create($params);
            if ($r['success'])
            {
                $user->login();
                json_success(array('redirect' => site_url('signup/step/1')));
            }
            else
            {
                json_error($r['message']);
            }
        }
        else
        {
            custom_404();
            return;
        }
    }
    
    
    public function step($n = 1)
    {
        $this->user->get_email();
        
        switch($n)
        {
            case 1:
                if ($this->user->onboarding_step != 1)
                {
                    redirect('/signup/step/'.$this->user->onboarding_step);
                }
                break;
            case 2:
                if ($_SERVER['REQUEST_METHOD'] != 'POST' AND $this->user->onboarding_step != $n)
                {
                    redirect('/signup/step/'.$this->user->onboarding_step);
                }
                elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    if ($this->input->post('save'))
                    {
                        $params = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'gender' => $this->input->post('gender'),
                            'income_range' => $this->input->post('income_range'),
                            'bday' => $this->input->post('bday'),
                        );
                        $this->user->set_profile_info($params);
                    }
                    
                    $this->user->set_onboarding_step(2);
                }
                break;
            default:
                custom_404();
                return;
        }

        $data = array(
            'user' => $this->user,
        );        
        $this->load->view('signup/step'.$n, $data);
    }
    
    
    public function finish()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' OR !$this->user->onboarding_step)
        {
            custom_404();
            return;
        }
        
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        
        if ( !$this->user->first_name OR !$this->user->last_name)
        {
            $this->user->get_profile_info();
            $params = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->user->gender,
                'income_range' => $this->user->income_range,
                'bday' => $this->user->bday,
            );
            $this->user->set_profile_info($params);
        }

        if ($this->input->post('send'))
        {
            $friends_emails = explode(',', $this->input->post('friends_emails'));
            foreach ($friends_emails as $k => $email)
            {
                $friends_emails[$k] = trim($email);
                if ( ! $friends_emails[$k])
                {
                    unset($friends_emails[$k]);
                }
            }
            $params = array(
                'email_type' => 1,
                'user' => $this->user,
                'emails' => $friends_emails,
            );
            $this->load->library('sendgrid', $params);
            $this->sendgrid->compose_email($this->user, $first_name.' '.$last_name);
            $r = $this->sendgrid->send_email();
        }
        
        $this->user->set_onboarding_step(0);
        
        redirect('/');
    }
}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */