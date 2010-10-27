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
		
		//TODO: maybe some friend detection here
	}

    function index() {
        
    }

    function details($pid=false) {
        
        if($pid === false){
            $pid = $this->user['uid'];
        }
        
        $view_data = array();
            
        // logged in user
        $view_data['user'] = $this->user;
        // profile user
        $view_data['profile_user'] = $this->User_m->get_user_by_uid($pid);
        $view_data['trips'] = $this->Trip_m->get_user_trips($pid);
        $view_data['profile_user_friends'] = $this->User_m->get_friends_by_uid($pid);
        //TODO: get some friends!
        
        
        $this->load->view('profile', $view_data);
    }

}

