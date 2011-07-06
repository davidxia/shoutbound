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
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->user->get_email()->get_profile_info();
            $data = array(
                'user' => $this->user,
            );
            $this->load->view('my_account/settings', $data);
        }
        else
        {
            $email = $this->input->post('email');
            $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i';
            if ( ! preg_match($pattern, $email))
            {
                $valid_email = 0;
            }
            else
            {
                $valid_email = 1;
                $this->user->set_email($email);
            }

            $params = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'income_range' => $this->input->post('income_range'),
                'bday' => $this->input->post('bday'),
                'zipcode' => $this->input->post('zipcode'),
            );
            
            $error = FALSE;
            if ( ! $this->user->set_profile_info($params))
            {
                $error = TRUE;
            }
            
            if ($this->input->post('old_pw'))
            {
                $this->user->get_password();
                if (md5('davidxia'.$this->input->post('old_pw').'isgodamongmen') == $this->user->password AND
                    $this->input->post('new_pw') == $this->input->post('conf_new_pw'))
                {
                    $correct_pw = 1;
                    if ( ! $this->user->set_password($this->input->post('new_pw')))
                    {
                        $error = TRUE;
                    }
                }
                else
                {
                    $correct_pw = 0;
                }
            }
            
            if ($error)
            {
                json_error('saved');
            }
            else
            {
                $arr = array('message' => 'saved', 'valid_email' => $valid_email);
                if ($this->input->post('old_pw'))
                {
                    $arr['correct_pw'] = $correct_pw;
                }
                json_success($arr);
            }
        }
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