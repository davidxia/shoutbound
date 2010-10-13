<?php

class Trip extends Controller {

	function Trip()
	{
		parent::Controller();
		
		//list
		$this->load->model('List_m');
		
		//TODO: map
		
		//TODO: wall
		$this->load->model('Wall_m');
		
		//authentication
		$logged_in_user = $this->User_m->get_logged_in_user();
		if(!$logged_in_user){
		    redirect(site_url('index'),'refresh');
		}
	}


    function index() {
        
        //getting data for sub-sections
        $list_data = array( 'list_items' => $this->List_m->get_list_for_user('uid'));
        $wall_data = array( 'wall_items' => $this->Wall_m->get_wall_items_for_user('uid'));
        
        $view_data = array(
            'list_data' => $list_data,
            'wall_data' => $wall_data,
            'trip_data' => array('name'=>'New York 2011')
        );
        
        $this->load->view('trip', $view_data);
    }
    
    
}

