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
        $latlngbounds = $_POST['latLngBounds'];
        $mapcenter = $_POST['mapCenter'];
        $tripid = $_POST['tripid'];
        $a = $this->Trip_m->update_latlngbounds_by_tripid($latlngbounds, $tripid);
        $b = $this->Trip_m->update_mapcenter_by_tripid($mapcenter, $tripid);
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
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['trip_id']);
        $title = trim($_POST['title']);
        if(!$title)
            return json_error('You need a title!');
        if(!$trip)
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
            $this->user['uid'],
            $trip['tripid'],
            $_POST['yelp_id'],
            $title,
            $_POST['body'],
            $_POST['yelpjson'],
            $_POST['lat'],
            $_POST['lon'],
            $trip['uid'],
            $replyid,
            $is_location
        ); 

        
        // Generate email to the other people on this chain
        $has_been_emailed = array($this->user['uid'] => true);
        $this->load->library('sendgrid_email');
        if($replyid) {
            $author = $this->user;
            $owner = $this->User_m->get_user_by_uid($trip['uid']);
            
            $reply_item = $this->Trip_m->get_item_by_id($replyid);
            $uids = $this->Trip_m->get_uids_in_thread($reply_item);
            for($i = 0; $i < count($uids); $i++) {
                $uid = $uids[$i];
                if($has_been_emailed[$uid])
                    continue;
                $user_settings = $this->User_m->get_settings($uid);
                if($user_settings['replies'] == 2 ||
                   ($user_settings['replies'] == 1 && $i == count($uids)-1)) {

                    $user = $this->User_m->get_user_by_uid($uid);
                    $this->sendgrid_email->send_mail(
                        array($user['email']),
                        $author['name'].' has commented on '.$owner['name']."'s trip - ".$trip['name'],
                        $this->_add_link_to_notification('<h4>'.$author['name'].' has commented on '.$owner['name']."'s trip - ".$trip['name'].'</h4>'.$author['name'].' wrote: ',$trip, $_POST['body']),
                        $this->_add_link_to_notification($author['name'].' has commented on '.$owner['name']."'s trip - ".$trip['name'],$trip, $_POST['body'])
                    );
                    $has_been_emailed[$uid] = true;
                }
            }
        }

        // Generate email to the owner
        if(!$has_been_emailed[$trip['uid']]) {
            $author = $this->user;
            $owner = $this->User_m->get_user_by_uid($trip['uid']);
            $user_settings = $this->User_m->get_settings($trip['uid']);
            if($replyid && $user_settings['trip_reply']) {
                $this->sendgrid_email->send_mail(array($owner['email']),
                    $author['name'].' has replied to a post on your trip',
                    $this->_add_link_to_notification('<h4>'.$author['name'].' has replied to a post on your trip - '.$trip['name'].'</h4>'.$author['name'].' wrote: ',$trip, $_POST['body']),
                    $this->_add_link_to_notification($author['name'].' has replied to a post on your trip '.$trip['name'],$trip, $_POST['body'])
                );
            } else if($is_location && $user_settings['trip_suggestion']) {
                $this->sendgrid_email->send_mail(array($owner['email']),
                    $author['name'].' has made a suggestion on your trip',
                    $this->_add_link_to_notification('<h4>'.$author['name'].' has made a suggestion on your trip - '.$trip['name'].'</h4>'.$author['name'].' suggested: '.$title,$trip),
                    $this->_add_link_to_notification($author['name'].' has made a suggestion on your trip '.$trip['name'],$trip)
                );
            } else if($user_settings['trip_post']) {
                $this->sendgrid_email->send_mail(array($owner['email']),
                    $author['name'].' has made a post on your wall',
                    $this->_add_link_to_notification('<h4>'.$author['name'].' has made a post on your trip - '.$trip['name'].'</h4>'.$author['name'].' wrote: ',$trip, $_POST['body']),
                    $this->_add_link_to_notification($author['name'].' has made a post on your trip '.$trip['name'],$trip, $_POST['body'])
                );
            }
        }


        if($is_location){
            json_success(array(
                'biz' => $_POST['yelpjson'],
                'name'=> $this->user['name'],
                'body'=> $_POST['body'],
                'fid' => $this->user['fid'],
            ));
        } else {
            json_success(array(
                'fid' => $this->user['fid'],
                'body'=> $_POST['body'],
                'name'=> $this->user['name'],
            ));
        }
        //echo ($foo);
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