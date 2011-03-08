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
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        $u->settings->get();

        $view_data = array(
          'settings' => $u->settings->stored,
        );
        
        $this->load->view('settings', $view_data);
    }
    
    
    function ajax_update_settings()
    {
        $u = new User();
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        if ($this->input->post('trip_suggestion')==1 AND
            $this->input->post('trip_post')==1 AND
            $this->input->post('trip_reply')==1 AND
            $this->input->post('replies')==2)
        {
            $u->setting_id = 1;
        }

        
        if ($this->input->post('trip_suggestion')==1 AND
          $this->input->post('trip_post')==1 AND
          $this->input->post('trip_reply')==1 AND
          $this->input->post('replies')==1)
        {
            $u->setting_id = 2;
        }

        if ($u->save())
        {
            json_success(array('message' => 'Settings saved'));
        }
        
        // TODO: decide what settings we need and assign numbers for each
        
    }
    

}


/* End of file settings.php */
/* Location: ./application/controllers/settings.php */