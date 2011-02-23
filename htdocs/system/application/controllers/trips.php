<?php

class Trips extends Controller {
    
	function Trips()
	{
		parent::Controller();
	}


    function index()
    {
        $t = new Trip();
        $t->get_by_id(91);
        //$t->name = 'test trip 2';
        //$t->include_join_fields()->join_role = 3;
        //$t->include_join_fields()->join_rsvp = 2;
        $u = new User();
        $u->get_by_id(9);
        if ($t->set_join_field($u, 'role', 2) AND $t->set_join_field($u, 'rsvp', 3))
        {
            echo 'i changed hte field!'.$t->id;
        }
        
        //$t->save();
        //$u->save($t);
    }

 	

    function details($trip_id)
    {
        $t = new Trip();

        $u = new User();
        if ($u->get_logged_in_status())
        {
            $uid = get_cookie('uid');
            $u->get_by_id($uid);
            $user = $u->stored;
        }

        //check if trip exists in trips table and is active, ie not deleted
        $t->get_by_id($trip_id);
        if ( ! $t->active)
        {
            redirect('/');
        }
        // TODO: check if trip is private

        //check if user is associated with this trip in trips_users table, redirect to home page if not
        $u->trip->include_join_fields()->get_by_id($trip_id);
        if ( ! $u->trip->join_role)
        {
            redirect('/');
        }
        $user_role = $u->trip->join_role;
        $user_rsvp = $u->trip->join_rsvp;
        
        $u->where_join_field('trip', 'rsvp', 3)->where_join_field('trip', 'role', 2)->get_by_related_trip('id', $trip_id);
        foreach ($u->all as $other_user)
        {
            $trip_goers[] = $other_user->stored;
        }

        
        // get suggestions for both user's trips and her friends trips
        $s = new Suggestion();
        $s->where('trip_id', $trip_id)->where('active', 1)->get();
        foreach ($s->all as $suggestion)
        {
            $suggestion->stored->user_fid = $u->get_by_id($suggestion->user_id)->fid;
            $suggestion->stored->user_name = $u->name;
            $suggestion->stored->is_location = 1;
            $wall_items[] = $suggestion->stored;
            $suggestions[] = $suggestion->stored;
        }
        

        
        /*
        $items = $this->Trip_m->get_items_by_tripid($tripid, 'ASC');
        $wall_items = array('wall_items' => $this->Trip_m->format_items_as_thread($items));
        */
        
        $view_data = array('trip' => $t->stored,
                           'user' => $user,
                           'user_role' => $user_role,
                           'user_rsvp' => $user_rsvp,
                           'wall_items' => $wall_items,
                           'suggestions' => $suggestions,
 			               'trip_goers' => $trip_goers);
 			               
        
        $this->load->view('trip', $view_data);
    }
    
    
    function share($id, $hash){
        //$hash = '912ec803b2ce49e4a541068d495ab570';
        //$id = 2;
        
        $trip_share = $this->Trip_m->get_tripshare_by_idhash($id, $hash);
        if(!$trip_share){
            redirect('/');
        }
        //echo 'trip_share row: '; print_r($trip_share); echo '<br/>';
        //delete_cookie('received_invites');

        //$cookie = json_encode(array(84=>'912ec803b2ce49e4a541068d495ab534',90=>'912ec803b2ce49e4a541068d495ab370'));
        //echo 'original cookie: '; print_r($cookie); echo '<br/>';
        //set_cookie('received_invites', $cookie);
        //echo 'now the cookie is '.get_cookie('received_invites').'<br/>';
        
        // if cookie is set, append new key value pair, otherwise instantiate new stdclass object
        if($received_invites = get_cookie('received_invites')){
            // unserialize from JSON
            $received_invites = json_decode($received_invites);
            $received_invites->{$trip_share['tripid']} = $trip_share['hash_key'];
        }else{
            $received_invites = (object)array($trip_share['tripid'] => $trip_share['hash_key']);
        }
        //echo 'new cookie yay: '; print_r($received_invites); echo '<br/>';
        // serialize to JSON and set cookie
        $received_invites = json_encode($received_invites);
        set_cookie('received_invites', $received_invites);
        
        redirect('/trips/details/'.$trip_share['tripid']);

    }
    
    
    function ajax_create_trip_panel()
    {
        $render_string = $this->load->view('trip/create_trip_panel', '', TRUE);
        json_success(array('data'=>$render_string));
    }
    
    
    function ajax_create_trip()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);

        $t = new Trip();
        $t->name = $this->input->post('tripName');
        if ($t->save() AND $u->save($t)
            AND $t->set_join_field($u, 'role', 2)
            AND $t->set_join_field($u, 'rsvp', 3))
        {
            $t->set_join_field($u, 'role', 2);
            $t->set_join_field($u, 'rsvp', 3);
            json_success(array('tripid' => $t->id));
        }        
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
    
    
    function ajax_rsvp_yes(){
        $a = $this->Trip_m->update_rsvp_by_tripid_uid($_POST['tripid'], $_POST['uid'], 'yes');
        json_success(array('success'=>$a));
    }
    
    
    function ajax_rsvp_no(){
        $a = $this->Trip_m->update_rsvp_by_tripid_uid($_POST['tripid'], $_POST['uid'], 'no');
        json_success(array('success'=>$a));
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
        
        $this->load->library('sendgrid_email');
        
        foreach($uids as $uid){
            // TODO: fix based on user notification settings
            $user_settings = $this->User_m->get_settings($uid);
            if(true) {
                $user = $this->User_m->get_user_by_uid($uid);
                $response = $this->sendgrid_email->send_mail(
                    array($user['email']),
                    $planner['name'].' shared a trip with you on ShoutBound!',
                    $this->_add_link_to_notification('<h4>'.$planner['name'].' shared a trip with you on ShoutBound!</h4>'.$planner['name'].' says: '.$message,$trip),
                    $this->_add_link_to_notification($planner['name'].' shared a trip with you on ShoutBound! '.$planner['name'].' says: '.$message,$trip)
                );
            }
        }
        
        $success = json_decode($response, true);
        
        // if the JSON response string from Sendgrid is 'success'
        // tell user it succeeded        
        if($success['message'] == 'success'){
            $view_data = array(
                //'uids' => $uids,
                'trip' => $trip,
                //'message' => $message
            );
            $render_string = $this->load->view('core_success', $view_data, true);
            json_success(array('data'=>$render_string));
        // otherwise, tell user his share failed
        } else {
            $view_data = array(
                'response' => json_decode($response, true),
            );
            $render_string = $this->load->view('core_failure', $view_data, true);
            json_success(array('data'=>$render_string));
        }
    }
    
    
    function _add_link_to_notification($message, $trip, $body=null){
        
        $ret_val = $message;
        
        if($body) {
            $ret_val .= ' "'.$body.'"';
        }
        
        $ret_val .= '<br/><a href="'.site_url('trip/details/'.$trip['tripid']).'">To see the trip, click here.</a>';
        $ret_val .= '<p><br/>Have fun! Team Shoutbound</p>';
        
        return $ret_val;
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
        $planner = $this->user;
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        $uids = json_decode($_POST['uids']);
        $message = $_POST['message'];
        
        $this->load->library('sendgrid_email');
        
        foreach($uids as $uid){
            // TODO: fix based on user notification settings
            $user_settings = $this->User_m->get_settings($uid);
            if(true) {
                $user = $this->User_m->get_user_by_uid($uid);
                $response = $this->sendgrid_email->send_mail(
                    array($user['email']),
                    $planner['name'].' invited you on a trip on Shoutbound!',
                    $this->_add_link_to_notification('<h4>'.$planner['name'].' invited you a trip on ShoutBound!</h4>'.$planner['name'].' says: '.$message,$trip),
                    $this->_add_link_to_notification($planner['name'].' invited you on a trip on ShoutBound! '.$planner['name'].' says: '.$message,$trip)
                );
            }
        }
        
        $success = json_decode($response, true);
        $db_update = $this->Trip_m->invite_uids_by_tripid($_POST['tripid'], $uids);

        
        // if the JSON response string from Sendgrid is 'success'
        // tell user it succeeded        
        if($success['message'] == 'success' && $db_update){
            $view_data = array(
                //'uids' => $uids,
                'trip' => $trip,
                //'message' => $message
            );
            $render_string = $this->load->view('core_success', $view_data, true);
            json_success(array('data'=>$render_string));
        // otherwise, tell user his share failed
        } else {
            $view_data = array(
                'response' => json_decode($response, true),
            );
            $render_string = $this->load->view('core_failure', $view_data, true);
            json_success(array('data'=>$render_string));
        }
    }
    
    
    function ajax_wall_post(){
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
            null,
            $_POST['body'],
            $_POST['yelpjson'],
            $_POST['lat'],
            $_POST['lon'],
            $replyid
        );

        // check if row was created in database
        if($itemid){
            json_success(array(
                'itemid' => $itemid,
                'fid' => $this->user['fid'],
                'name'=> $this->user['name'],
                'body'=> $_POST['body'],
                'replyid' => $replyid
            ));
        }
    }
    
    
    function remove_trip_item(){
        $item = $this->Trip_m->get_item_by_itemid($_POST['itemid']);
        if(!$item)
            return json_error('That item doesn\'t exist');

        $itemid = $this->Trip_m->remove_trip_item_by_itemid($_POST['itemid'], $_POST['tripid']);
        
        json_success(array('itemid' => $itemid));
    }
    
    
    function remove_wall_replies(){
        $parent = $this->Trip_m->get_item_by_itemid($_POST['replyid']);
        if(!$parent)
            return json_error('That thread doesn\'t exist');
            
        $itemids = $this->Trip_m->get_itemids_by_replyid($_POST['replyid']);
        foreach($itemids as $itemid){
            $this->Trip_m->remove_trip_item_by_itemid($itemid, $_POST['tripid']);
        }
    }
    
    function save_trip_startdate(){
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripid']);
        if(!$trip)
            return json_error('That trip doesn\'t exist');
        
        $a = $this->Trip_m->update_startdate_by_tripid($_POST['tripid'], $_POST['tripStartDate']);
        json_success(array('success'=>$a));
    }
    
    
    function ajax_save_new_marker(){
        $itemid = $this->Trip_m->create_item(
            $this->user['uid'],
            $this->input->post('tripid'),
            null,
            $this->input->post('name'),
            null,
            null,
            $this->input->post('lat'),
            $this->input->post('lng'),
            0,
            1,
            $this->input->post('address'),
            $this->input->post('phone')
        );
        

        // check if row was created in database        
        if($itemid){
            json_success(array(
                'itemid' => $itemid,
                'fid' => $this->user['fid'],
                'name' => $this->user['name'],
                'marker_name' => $_POST['name'],
                'body' => $_POST['body'],
                'islocation' => true,
                'replyid' => 0,
            ));
        }
    }    
    
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
    //function _filter_out_wall_data($in_data){
        //$out_data = array();
        //foreach($in_data as $item){
            //if($item['islocation']){
                //$out_data[] = $item;
            //}
        //}
        
        //return $out_data;
    //}
    
    //function do_ajax_suggestion(){
        //$foo = $_POST['foo'];
        //echo $foo;
    //}
}