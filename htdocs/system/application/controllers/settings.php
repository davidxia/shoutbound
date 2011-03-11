<?php

class Settings extends Controller
{
    
    function Settings()
    {
    	  parent::Controller();
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
    }
    

    function index()
    {
        $u = new User();
        $u->get_by_id(get_cookie('uid'));
        $u->settings->get();

        $view_data = array(
            'user' => $u->stored,
            'settings' => $u->settings->stored,
        );
        
        $this->load->view('settings', $view_data);
    }
    
    
    function ajax_update_settings()
    {
        $u = new User();
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        $s = $this->input->post('tripInvite').$this->input->post('tripPost').$this->input->post('postReply');
        
        switch ($s)
        {
            case '111':
                $u->setting_id = 1;
                break;
            case '110':
                $u->setting_id = 2;
                break;
            case '101':
                $u->setting_id = 3;
                break;
            case '100':
                $u->setting_id = 4;
                break;
            case '011':
                $u->setting_id = 5;
                break;
            case '010':
                $u->setting_id = 6;
                break;
            case '001':
                $u->setting_id = 7;
                break;
            case '000':
                $u->setting_id = 8;
                break;
        }
        
        if ($u->save())
        {
            json_success(array('message' => 'Settings updated'));
        }        
    }
    

}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */