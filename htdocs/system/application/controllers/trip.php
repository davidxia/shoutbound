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
        
        $trip = $this->Trip_m->get_trip_by_tripid($trip_id);
        $trip_user = $this->User_m->get_user_by_uid($trip['uid']);
        
        if(!$trip){
            redirect('/');
        }
        
        //getting data for sub-sections
        $complete_data = $this->Trip_m->get_items_by_tripid($trip_id);
        $wall_data = array('wall_items' => $complete_data);
        $list_data = array('list_items' => $this->_filter_out_wall_data($complete_data));
        

        //$wall_data = array( 'wall_items' => $this->Wall_m->get_wall_items_for_user('uid'));
        
        $view_data = array(
            'user'      => $this->user,
            'list_data' => $list_data,
            'wall_data' => $wall_data,
            'trip_data' => array(
                'name'=>$trip['name'],
                'id'=>$trip_id,
                'uid'=>$trip_user['uid'],
                'fid' => $trip_user['fid'],
                'lat' => $trip['lat'],
                'lon' => $trip['lon'],
                'user_name' => $trip_user['name']
            )
        );
        
        $this->load->view('trip', $view_data);
    }
    
    function _filter_out_wall_data($in_data){
        $out_data = array();
        foreach($in_data as $item){
            if($item['islocation']){
                $out_data[] = $item;
            }
        }
        
        return $out_data;
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
        
        $is_location = true;
        if($_POST['islocation']===null){
            $is_location = true;
        } else {
            $is_location = $_POST['islocation'];
        }

        //TODO: check for body or content when adding items

        $this->Trip_m->create_item(
            $this->User_m->get_logged_in_uid(),
            $_POST['trip_id'],
            $_POST['yelp_id'],
            $title,
            $_POST['body'],
            $_POST['yelpjson'],
            $_POST['lat'],
            $_POST['lon'],
            $replyid,
            $is_location
        ); 
        
        if($is_location){
            json_success(array(
                    'biz' => $_POST['yelpjson'],
                    'name'=> $this->user['name'],
                )
            );
        } else {
            json_success(array(
                    'fid' => $this->user['fid'],
                    'body'=> $_POST['body'],
                    'name'=> $this->user['name'],
                )
            );
        }
        //echo ($foo);
    }
    
    
    function ajax_get_list_items(){
        //$trip_items = $this->Trip_m->get_items_by_tripid($_POST['trip_id'])
        //json_sucess($trip_items);
    }
}

