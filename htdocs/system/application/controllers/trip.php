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
        $this->user = $this->User_m->get_logged_in_user();
        
        //print_r($this->user);
        
        if(!$this->user){
            redirect('/');
		}
	}


    function index() {
        echo "you want to go to trip details.";
    }


    function details($trip_id){
        
        //getting data for sub-sections
        $list_data = array('list_items' => $this->Trip_m->get_items_by_tripid($trip_id));
        //array( 'list_items' => $this->List_m->get_list_for_user('uid'));
        
        $wall_data = array( 'wall_items' => $this->Wall_m->get_wall_items_for_user('uid'));
        
        $view_data = array(
            'user'      => $this->user,
            'list_data' => $list_data,
            'wall_data' => $wall_data,
            'trip_data' => array('name'=>$trip_id, 'id'=>$trip_id)
        );
        
        $this->load->view('trip', $view_data);
    }
    
    
    function do_ajax_suggestion(){
        $foo = $_POST['foo'];
        echo $foo;
    }
    
    
    function ajax_add_item(){
        $title = trim($_POST['title']);
        if(!$title)
            return json_error('You need a title!');
        if(!$this->Trip_m->get_trip_by_tripid($_POST['trip_id']))
            return json_error('That trip doesn\'t exist');

        $replyid = $_POST['reply_id'];
        if(!$replyid)
            $replyid = 0;

        $this->Trip_m->create_item(
            $this->User_m->get_logged_in_uid(),
            $_POST['trip_id'],
            $_POST['yelp_id'],
            $title,
            "default body",
            $_POST['lat'],
            $_POST['lon'],
            $replyid
        );
        
        json_success(array());
        //echo ($foo);
    }
    
    
    function ajax_get_list_items(){
        //$trip_items = $this->Trip_m->get_items_by_tripid($_POST['trip_id'])
        //json_sucess($trip_items);
    }
}

