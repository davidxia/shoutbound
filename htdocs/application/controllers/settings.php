<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
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
        else
        {
            redirect('/');
        }
		}
    

    public function index()
    {
        $this->user->get_email()
             ->get_settings();
        $s = new Setting_m();        

        $data = array(
            'user' => $this->user,
            'settings' => $s->get_all_settings(),
        );
        $this->load->view('settings/index', $data);
    }
    
    
    public function profile()
    {
        $this->user->get_current_place();//->get_past_places();
        
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('settings/profile', $data);
    }
    
    
    public function trail()
    {
        $this->user->get_past_places();
        
        $data = array(
            'user' => $this->user,
        );
        $this->load->view('settings/trail', $data);
    }


    public function ajax_save_settings()
    {
        $new_email = $this->input->post('email');
        $this->user->get_email();
        if ($this->user->email != $new_email)
        {
            if ( ! $this->user->set_email($new_email))
            {
                $error = TRUE;
            }
        }
        
        $pw_incorrect = 0;
        if ($this->input->post('oldPw'))
        {
            $this->user->get_password();
            if (md5('davidxia'.$this->input->post('oldPw').'isgodamongmen') == $this->user->password AND
            $this->input->post('newPw') == $this->input->post('confNewPw'))
            {
                if ( !$this->user->set_password(md5('davidxia'.$this->input->post('newPw').'isgodamongmen')))
                {
                    $error = TRUE;
                }
            }
            else
            {
                $pw_incorrect = 1;
            }
        }
        
        $s = new Setting_m();
        $settings = $s->get_all_settings();
        foreach ($settings as $setting)
        {
            if ( ! $this->user->set_setting_by_setting_id($setting_id, $this->input->post($setting->name)))
            {
                $error = TRUE;
            }
        }
        $this->mc->delete('settings_by_user_id:'.$this->user->id);
        
        if ( !$error AND !$pw_incorrect)
        {
            $data = array('str' => json_success(array('response' => 'saved'));
        }
        elseif ( !$error AND $pw_incorrect)
        {
            $data = array('str' => json_error('incorrect password'));
        }
        elseif ( !$error)
        {
            $data = array('str' => json_error('something broken'));
        }
    }
}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */