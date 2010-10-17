<?php

class Profile extends Controller {
    
    function Profile()
	{
		parent::Controller();
		
		//authentication
        $this->user = $this->User_m->get_logged_in_user();
        if(!$this->user){
            redirect('/');
		}
	}

    function index() {
        $view_data = array();
        
        $view_data['user'] = $this->user;
        $view_data['trip_ids'] = $this->Trip_m->get_user_tripids($this->user['uid']);
        
        
        $this->load->view('profile', $view_data);
    }

}

