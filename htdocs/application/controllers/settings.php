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
        //print_r($this->user->stored);
    }
    
    
    public function ajax_save_settings()
    {
        $this->user->email = $this->input->post('email');
        
        $pw_incorrect = 0;
        if ($this->input->post('oldPw'))
        {
            if (md5('davidxia'.$this->input->post('oldPw').'isgodamongmen') == $this->user->password AND
            $this->input->post('newPw') == $this->input->post('confNewPw'))
            {
                $this->user->password = md5('davidxia'.$this->input->post('newPw').'isgodamongmen');
            }
            else
            {
                $pw_incorrect = 1;
            }
        }
        
        if ($this->user->save())
        {
            $s = new Setting();
            foreach ($s->get_iterated() as $setting)
            {
                if ($this->user->save($setting))
                {
                    $this->user->set_join_field($setting, 'is_on', $this->input->post($setting->name));
                }
            }
            
            json_success(array('response' => 'Saved.', 'pwIncorrect' => $pw_incorrect));
        }
        else
        {
            if ($this->user->error->email)
            {
                json_success(array('response' => '', 'emailTaken' => 1, 'pwIncorrect' => $pw_incorrect));
            }
            else
            {
                json_success(array('response' => 'Uh oh, something broke. Try again later.'));
            }
        }

    }
}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */