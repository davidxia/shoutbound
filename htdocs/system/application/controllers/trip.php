<?php

class Trip extends Controller {
    
	function Trip() {
		parent::Controller();
		//check that user is logged in
        $this->user = $this->User_m->get_logged_in_user();
        if(!$this->user) { redirect('/'); }
	}


    function index() {
 	}
 	

    function details($tripid){
        //check if trip exists in trips table and is active, ie not deleted
        $trip = $this->Trip_m->get_trip_by_tripid($tripid);
        if(!$trip) { redirect('/'); }

        //check if user is associated with this trip in trips_users table
        //redirect to home page if not
        $trip_uids = $this->Trip_m->get_uids_by_tripid($tripid);
        for($i = 0; $i < count($trip_uids); $i++) {
            if($trip_uids[$i] == $this->user['uid']) { break; }
            if($i == (count($trip_uids)-1)) { redirect('/'); }
        }
        
        //get this user's type for this trip
        $user_type = $this->Trip_m->get_type_by_tripid_uid($tripid, $this->user['uid']);
        
 		//get users and corresponding rsvps for this trip
 		foreach($trip_uids as $i => $uid) {
 		    $uids_rsvps[$uid] = $this->Trip_m->get_rsvp_by_tripid_uid($tripid, $uid);
 		}
 		
 		//get users who rsvp yes
 		foreach($uids_rsvps as $uid => $rsvp) {
            if($rsvp == 'yes') { $yes_users[] = $this->User_m->get_user_by_uid($uid); }
 		}
        
        //getting data for sub-sections
        $items = $this->Trip_m->get_items_by_tripid($tripid, 'ASC');
        $wall_data = array('wall_items' => $this->Trip_m->format_items_as_thread($items));
        $list_data = array('list_items' => array_reverse($this->_filter_out_wall_data($items)));

        $view_data = array('user' => $this->user,
                           'user_type' => $user_type,
                           //'trip_user' => $trip_user,
                           'list_data' => $list_data,
                           'wall_data' => $wall_data,
                           'trip' => $trip,
                           //'trips' => $this->Trip_m->get_user_trips($this->user['uid']),
                           //'current_trip' => $trip,
 			               //'in_users' =>$in_users,
 			               'yes_users' => $yes_users,
                           );
        
        $this->load->view('trip', $view_data);
    }
    
    
    function ajax_panel_create_trip() {
        $render_string = $this->load->view('trip/trip_create_panel', '', true);
        json_success(array('data'=>$render_string));
    }
    
    
    function ajax_create_trip(){
        $tripid = $this->Trip_m->create_trip($this->user['uid'], $_POST['tripWhat']);
        json_success(array('tripid'=>$tripid));
    }
    
    
    function delete() {        
        $this->Trip_m->delete_trip($_POST['tripid']);
    }
    
    
    function ajax_update_map() {
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $sBound = $_POST['sBound'];
        $wBound = $_POST['wBound'];
        $nBound = $_POST['nBound'];
        $eBound = $_POST['eBound'];
        $tripid = $_POST['tripid'];
        
        $a = $this->Trip_m->update_mapcenter_by_tripid($lat, $lng, $tripid);
        $b = $this->Trip_m->update_latlngbounds_by_tripid($sBound, $wBound, $nBound, $eBound, $tripid);
        $c = $a && $b;
        
        json_success(array('success'=>$c));
    }
    
    
    function ajax_panel_share_trip() {
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        $friends = $this->User_m->get_friends_by_uid($this->user['uid']);
        
        $view_data = array(
            'user_friends' => $friends
        );
        
        $render_string = $this->load->view('trip/trip_share_panel', $view_data, true);
        json_success(array('data'=>$render_string));
    }
    
    
    function ajax_share_trip() {
        $planner = $this->user;
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        $uids = json_decode($_POST['uids']);
        $message = $_POST['message'];
        
        //$this->load->library('sendgrid_email');
        
        //for($i = 0; $i < count($uids); $i++) {
            //$uid = $uids[$i];

            //$user_settings = $this->User_m->get_settings($uid);
            //if(true) {

                //$user = $this->User_m->get_user_by_uid($uid);
                //$this->sendgrid_email->send_mail(
                    //array($user['email']),
                    //$planner['name'].' shared a trip with you on noqnok!',
                    //$this->_add_link_to_notification('<h4>'.$planner['name'].' shared a trip with you on noqnok! </h4>'.$planner['name'].' says: '.$message,$trip),
                    //$this->_add_link_to_notification($planner['name'].' shared a trip with you on noqnok! '.$planner['name'].' says: '.$message,$trip)
                //);
  
            //}
        //}

        $view_data = array(
            'uids' => $uids,
            'trip' => $trip,
            'message' => $message
        );
        
        $render_string = $this->load->view('core_success', $view_data, true);
        json_success(array('data'=>$render_string));
    }
    
    
    function ajax_panel_invite_trip() {
        $friends = $this->User_m->get_friends_by_uid($this->user['uid']);
        
        $not_invited_users = array();
        foreach($friends as $friend) {
            $rsvp = $this->Trip_m->get_rsvp_by_tripid_uid($_POST['tripid'], $friend['uid']);
            if($rsvp['rsvp'] == NULL) {
                $not_invited_users[] = $friend;
            }
        }
        
        $invited_users = array();
        foreach($friends as $friend) {
            $rsvp = $this->Trip_m->get_rsvp_by_tripid_uid($_POST['tripid'], $friend['uid']);
            if($rsvp['rsvp'] != NULL) {
                $invited_users[] = $friend;
            }
        }
        
        $view_data = array(
            'user' => $this->user,
            'trip' => $trip,
            'user_friends' => $friends,
            'not_invited_users' => $not_invited_users,
            'invited_users' => $invited_users,
        );
        
        $render_string = $this->load->view('trip/trip_invite_panel', $view_data, true);
        json_success(array('data'=>$render_string));
    }

    function ajax_invite_trip() {
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        $uids = json_decode($_POST['uids']);

        $view_data = array(
            'trip' => $trip,
            'uids' => $uids
        );
        
        $altered = $this->Trip_m->invite_uids_by_tripid($_POST['tripid'], $uids);
        if($altered) {
            $render_string = $this->load->view('core_success', $view_data, true);
            json_success(array('data'=>$render_string));
        }
    }
    
    
    function wall_post(){
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        if(!$trip)
            return json_error('That trip doesn\'t exist');
            
        if(isset($_POST['replyid'])) {
            $replyid = $_POST['replyid'];
        } else {
            $replyid = 0;
        }

        $itemid = $this->Trip_m->create_item(
            $this->user['uid'],
            $trip['tripid'],
            $_POST['yelp_id'],
            $_POST['body'],
            $_POST['yelpjson'],
            $_POST['lat'],
            $_POST['lon'],
            $replyid
            //$_POST['islocation']
        );
        
        if($_POST['islocation']) {
            json_success(array(
                'biz' => $_POST['yelpjson'],
                'name'=> $this->user['name'],
                'body'=> $_POST['body'],
                'fid' => $this->user['fid'],
            ));
        } else {
            json_success(array(
                'itemid' => $itemid,
                'fid' => $this->user['fid'],
                'name'=> $this->user['name'],
                'body'=> $_POST['body'],
                'replyid' => $replyid
            ));
        }
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
    

    function _add_link_to_notification($message, $trip, $body=null){
        
        $ret_val = $message;
        
        if($body) {
            $ret_val .= ' "'.$body.'"';
        }
        
        $ret_val .= '<br/><a href="'.site_url('trip/details/'.$trip['tripid']).'">To see the trip, click here.</a>';
        $ret_val .= '<p><br/> Have fun! </br> Team noqnok</p>';
        
        return $ret_val;
    }

}