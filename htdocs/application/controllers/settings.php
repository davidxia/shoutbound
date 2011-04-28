<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u;
        }
        else
        {
            custom_404();
            return;
        }
		}
    

    public function index()
    {
        $this->user->get_settings();
        $s = new Setting();        

        $data = array(
            'user' => $this->user->stored,
            'settings' => $s->get_settings(),
        );
        
        $this->load->view('settings/index', $data);
    }
    
    
    public function profile()
    {
        $this->user->get_current_place();
        $this->user->get_places();
        $data = array(
            'user' => $this->user->stored,
        );
 			               
        $this->load->view('settings/profile', $data);
    }
    
    
    public function ajax_save_settings()
    {
        $this->user->email = $this->input->post('email');
        if (md5('davidxia'.$this->input->post('oldPw').'isgodamongmen') == $this->user->password AND
            $this->input->post('newPw') == $this->input->post('confNewPw'))
        {
            $this->user->password = md5('davidxia'.$this->input->post('newPw').'isgodamongmen');
        }
        
        if ($this->user->save())
        {
            $s = new Setting();
            $error = FALSE;
            foreach ($s->get_iterated() as $setting)
            {
                if ( ! $this->user->set_join_field($setting, 'is_on', $this->input->post($setting->name)))
                {
                    $error = TRUE;
                }
            }
    
            if ( ! $error)
            {
                echo 'settings saved';
            }
            else
            {
                echo 'Uh oh, something broke. Try again later.';
            }
        }
        else
        {
            if ($this->user->error->email)
            {
                $message = '';
                echo 'That e-mail is already taken.';
            }
            else
            {
                echo 'Uh oh, something broke. Try again later.';
            }
        }
    }
}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */