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
        $this->user->settings->get();

        $data = array(
            'user' => $this->user->stored,
            'settings' => $this->user->settings->stored,
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
    
    
    public function ajax_update_settings()
    {
        $s = $this->input->post('tripInvite').$this->input->post('tripPost').$this->input->post('postReply');
        
        switch ($s)
        {
            case '111':
                $this->user->setting_id = 1;
                break;
            case '110':
                $this->user->setting_id = 2;
                break;
            case '101':
                $this->user->setting_id = 3;
                break;
            case '100':
                $this->user->setting_id = 4;
                break;
            case '011':
                $this->user->setting_id = 5;
                break;
            case '010':
                $this->user->setting_id = 6;
                break;
            case '001':
                $this->user->setting_id = 7;
                break;
            case '000':
                $this->user->setting_id = 8;
                break;
        }
        
        if ($this->user->save())
        {
            json_success(array('message' => 'Settings updated'));
        }        
    }
}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */