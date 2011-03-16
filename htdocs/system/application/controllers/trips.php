<?php

class Trips extends Controller
{
    
    function Trips()
    {
        parent::Controller();
    }
    
    
    function facebook_test()
    {
        $this->load->view('facebook_test');
    }
    
    
 	  function confirm_create()
 	  {
        $u = new User();
        if ( ! $u->get_logged_in_status() OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        $post = $this->input->post('destinations_dates');
        $post = $post['destinations_dates'];

        $t = new Trip();
        $t->name = $post['trip_name'];
        $t->description = $post['description'];
        $deadline = date_parse_from_format('n/j/Y', $post['deadline']);
        {
            $t->response_deadline = mktime(0, 0, 0, $deadline['month'], $deadline['day'], $deadline['year']);
        }
        $t->is_private = ($post['private'] == 1) ? 1 : 0;
                
        if ($t->save() AND $u->save($t)
            AND $t->set_join_field($u, 'role', 3)
            AND $t->set_join_field($u, 'rsvp', 3))
        {
            // save trip's destinations and dates
            $d = new Destination();
            foreach ($post as $key => $value)
            {
                if (is_array($value))
                {
                    $d->clear();
                    $d->trip_id = $t->id;
                    $d->address = $post[$key]['address'];
                    $d->lat = $post[$key]['lat'];
                    $d->lng = $post[$key]['lng'];
                    
                    // gets each destination's startdate and enddate and stores as unix time
                    // TODO: callback method for better client side validation?
                    $startdate = date_parse_from_format('n/j/Y', $post[$key]['startdate']);
                    if (checkdate($startdate['month'], $startdate['day'], $startdate['year']))
                    {
                        $d->startdate = mktime(0, 0, 0, $startdate['month'], $startdate['day'], $startdate['year']);
                    }
                    $enddate = date_parse_from_format('n/j/Y', $post[$key]['enddate']);
                    if (checkdate($enddate['month'], $enddate['day'], $enddate['year']))
                    {
                        $d->enddate = mktime(0, 0, 0, $enddate['month'], $enddate['day'], $enddate['year']);
                    }
                    
                    $d->save();
                }
            }
            
            // send out emails based on invites input tag
            $this->load->library('sendgrid_email');
            $emails = explode(',', $post['invites']);
            foreach ($emails as $email)
            {
                $response = $this->sendgrid_email->send_mail(
                    array($email),
                    $u->name.' invited you on a trip on Shoutbound!',
                    $this->_add_link_to_notification('<h4>'.$u->name.' invited you to a trip on Shoubound</h4>'.$u->name.' says: '.$post['trip-description'], $t->id),
                    $this->_add_link_to_notification($u->name.' invited you to a trip on Shoutbound '.$u->name.' says: '.$post['trip-description'], $t->id)
                );
            }
            
            // TODO: success callback to ensure all destinations were saved?
            redirect('trips/'.$t->id);
        }      
 	  }

    function index($trip_id = FALSE)
    {
        if ( ! $trip_id)
        {
            redirect('/');
        }
        
        $t = new Trip();
        //check if trip exists in trips table and is active
        $t->get_by_id($trip_id);
        if ( ! $t->active)
        {
            redirect('/');
        }
        
        
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $user = $u->stored;
            
            // get user's relation to this trip
            $u->trip->include_join_fields()->get_by_id($trip_id);
            $user_role = $u->trip->join_role;
            $user_rsvp = $u->trip->join_rsvp;
            
            // if no relation, check if user has invite cookie with correct access key
            // redirect to home page if neither
            if ($t->is_private AND ! $user_role AND ! $this->verify_share_cookie($trip_id))
            {
                redirect('/');
            }
        }
        else
        {
            // if user is not logged in, check invite cookie for correct access key
            if ($t->is_private AND ! $this->verify_share_cookie($trip_id))
            {
                redirect('/');
            }
        }
        
        // get creator
        $u->where_join_field('trip', 'rsvp', 3)->where_join_field('trip', 'role', 3)->get_by_related_trip('id', $trip_id);
        $creator = $u->stored;
        
        // get users who are trip planners and rsvped yes
        $u->where_join_field('trip', 'rsvp', 3)->where_in_join_field('trip', 'role', array(2,3))->get_by_related_trip('id', $trip_id);
        foreach ($u->all as $other_user)
        {
            $trip_goers[] = $other_user->stored;
        }
        
        // get trip's destinations
        $d = new Destination();
        $d->where('trip_id', $trip_id)->get();
        foreach ($d->all as $destination)
        {
            $destinations[] = $destination->stored;
        }

        // get active suggestions and messages for this trip
        $m = new Message();
        $m->order_by('created', 'desc');
        $m->where('trip_id', $trip_id)->where('active', 1)->get();
        foreach ($m->all as $message)
        {
            $message->stored->user_id = $u->get_by_id($message->user_id)->id;
            $message->stored->user_name = $u->name;
            $wall_items[] = $message->stored;
        }
        
        $s = new Suggestion();
        $s->order_by('created', 'desc');
        $s->where('trip_id', $trip_id)->where('active', 1)->get();
        foreach ($s->all as $suggestion)
        {
            $suggestion->stored->user_id = $u->get_by_id($suggestion->user_id)->id;
            $suggestion->stored->user_name = $u->name;
            $wall_items[] = $suggestion->stored;
            $suggestions[] = $suggestion->stored;
        }
        
        $this->load->helper('quicksort');
        _quicksort($wall_items);
        
        $view_data = array(
            'trip' => $t->stored,
            'creator' => $creator,
            'destinations' => $destinations,
            'user' => $user,
            'user_role' => $user_role,
            'user_rsvp' => $user_rsvp,
            'wall_items' => $wall_items,
            'suggestions' => $suggestions,
            'trip_goers' => $trip_goers
        );
 			               
        $this->load->view('trip', $view_data);
    }
    
    
    function create($i=1)
    {        
        $u = new User();
        $uid = $u->get_logged_in_status();
        $u->get_by_id($uid);

        $view_data = array('user' => $u->stored,
                           'destination' => $this->input->post('destination'),
                           'destination_lat' => $this->input->post('destination_lat'),
                           'destination_lng' => $this->input->post('destination_lng'),
                           'is_landing' => 1,
                          );

        if ($i == 1)
        {
            $this->load->view('trip/create_1', $view_data);
        }
        elseif ($i == 2)
        {
            $this->load->view('trip/create_2', $view_data);
        }
    }
    
    
    function ajax_trip_create()
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
            json_success(array('tripId' => $t->id));
        }        
    }

    
    function ajax_rsvp_yes()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        $t = new Trip();
        $t->get_by_id($this->input->post('tripId'));
        
        if ($t->set_join_field($u, 'rsvp', 3))
        {
            json_success(array('success'=>true));
        }        
    }
    
    
    function ajax_rsvp_no()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        $t = new Trip();
        $t->get_by_id($this->input->post('tripId'));
        
        if ($t->set_join_field($u, 'rsvp', 1))
        {
            json_success(array('success'=>true));
        }        
    }

    
    
    function ajax_trip_invite_panel()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        // get user's non-Shoutbound friends
        $u->friend->get();
        $fb_friends = array();
        foreach ($u->friend as $friend)
        {
                $fb_friends[] = $friend->stored;
        }

        // get Shoutbound friends not related to this trip
        $u->related_user->get();
        // get user ids associated with this trip
        $t = new Trip();
        $t->get_by_id($this->input->post('tripId'));
        $t->user->get();        
        // create array of friends not associated with this trip
        foreach ($t->user->all as $user)
        {
            $trip_uids[] = $user->id;
        }
        $uninvited_sb_friends = array();
        foreach ($u->related_user as $sb_friend)
        {
            if ( ! in_array($sb_friend->id, $trip_uids))
            {
                $uninvited_sb_friends[] = $sb_friend->stored;
            }
        }
        
                
        $view_data = array(
            'fb_friends' => $fb_friends,
            'uninvited_sb_friends' => $uninvited_sb_friends,
        );
        
        $render_string = $this->load->view('trip/trip_invite_panel', $view_data, true);
        json_success(array('data' => $render_string));
        
    }


    function ajax_invite_trip()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid)
        {
            redirect('/');            
        }
        $u->get_by_id($uid);
        
        $trip_id = $this->input->post('tripId');
        
        $t = new Trip();
        $t->get_by_id($trip_id);

        $uids = json_decode($this->input->post('uids'));
        //$u->where_in('id', $uids)->get();
        
        $message = $this->input->post('message');
        
        $this->load->library('sendgrid_email');
        
        //if ( ! empty($uids))
        //{
        foreach ($uids as $uid)
        {
            $u->get_by_id($uid);
            $u->settings->get();
            
            $ts = new Trip_share();
            $ts->trip_id = $trip_id;
            $ts->share_role = 2;
            $ts->share_medium = 2;
            $ts->target_id = $u->email;
            $share_key = $ts->generate_share_key();
            
            if ($u->settings->trip_invite AND $share_key)
            {
                $response = $this->sendgrid_email->send_mail(
                    array($u->email),
                    $u->name.' invited you on a trip on Shoutbound!',
                    $this->_add_link_to_notification('<h4>'.$u->name.
                        ' invited you on a trip on ShoutBound!</h4>'.
                        $u->name.' says: '.$message, $trip_id, $share_key),
                    $this->_add_link_to_notification($u->name.
                        ' invited you on a trip on ShoutBound! '.
                        $u->name.' says: '.$message, $trip_id, $share_key)
                );
                
                $t->save($u);
                $t->set_join_field($u, 'role', 2);
                $t->set_join_field($u, 'rsvp', 2);
            }
        }
        //}
        
        // TODO: this success is overwritten until the last sent email
        $success = json_decode($response, true);
        
        // tell user if invite succeeded or failed based on JSON response
        if ($success['message'] == 'success')
        {
            $message = 'it worked';
            json_success(array('data' => $message));
        }
        else
        {
            $message = 'it failed';
            json_success(array('data' => $message));
        }
    }
    
        
    function share($trip_id, $share_key)
    {        
        $ts = new Trip_share();
        $trip_share = $ts->get_tripshare_by_tripid_sharekey($trip_id, $share_key);

        if ( ! $trip_share)
        {
            redirect('/');
        }
        
        // if cookie is set, append new key value pair, otherwise instantiate new stdclass object
        
        if ($received_invites = get_cookie('received_invites'))
        {
            // unserialize from JSON
            $received_invites = json_decode($received_invites);
            $received_invites->{$trip_share->trip_id} = md5('alea iacta est'.$share_key);
        }
        else
        {
            $received_invites = (object)array($trip_share->trip_id => md5('alea iacta est'.$share_key));
        }
        // serialize to JSON and set cookie
        $received_invites = json_encode($received_invites);
        set_cookie('received_invites', $received_invites);
        
        redirect('/trips/'.$trip_share->trip_id);
        
    }
    
    
    function delete($trip_id)
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        $t = new Trip();
        //check if trip exists in trips table and is active, ie not deleted
        $t->get_by_id($trip_id);
        if ( ! $t->active)
        {
            redirect('/');
        }

        //check if user is the creator, redirect to home page otherwise
        $u->trip->include_join_fields()->get_by_id($trip_id);
        if ($u->trip->join_role != 3)
        {
            redirect('/');
        }

        $t->where('id', $trip_id)->update('active', 0);
        redirect('/');
    }    
        
    /*
    function ajax_panel_share_trip()
    {
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripId']);
        $friends = $this->User_m->get_friends_by_uid($this->user['uid']);
        
        $view_data = array(
            'user_friends' => $friends
        );
        
        $render_string = $this->load->view('trip/trip_share_panel', $view_data, true);
        json_success(array('data'=>$render_string));
    }
    
    
    function ajax_share_trip()
    {
        $planner = $this->user;
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripId']);
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
    */
    
    function _add_link_to_notification($message, $trip_id, $share_key)
    {
        $ret_val = $message;
                
        $ret_val .= '<br/><a href="'.site_url('trips/share/'.$trip_id.'/'.$share_key).'">To see the trip, click here.</a>';
        $ret_val .= '<br/>Have fun!<br/>Team Shoutbound';
        
        return $ret_val;
    }

    
    /*
    function ajax_wall_post()
    {
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripId']);
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
    
    
    function remove_wall_replies()
    {
        $parent = $this->Trip_m->get_item_by_itemid($_POST['replyid']);
        if(!$parent)
            return json_error('That thread doesn\'t exist');
            
        $itemids = $this->Trip_m->get_itemids_by_replyid($_POST['replyid']);
        foreach($itemids as $itemid){
            $this->Trip_m->remove_trip_item_by_itemid($itemid, $_POST['tripId']);
        }
    }
    
    
    
    function save_trip_startdate()
    {
        $trip = $this->Trip_m->get_trip_by_tripid($_POST['tripId']);
        if(!$trip)
            return json_error('That trip doesn\'t exist');
        
        $a = $this->Trip_m->update_startdate_by_tripid($_POST['tripId'], $_POST['tripStartDate']);
        json_success(array('success'=>$a));
    }
    */
    

    function verify_share_cookie($trip_id)
    {
        $received_invites = json_decode(get_cookie('received_invites'));
        $share_key = $received_invites->$trip_id;

        $ts = new Trip_share();
        $ts->where('trip_id', $trip_id)->get();
        
        foreach ($ts->all as $trip_share)
        {
            if (md5('alea iacta est'.$trip_share->share_key) == $share_key)
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    
    function fb_friend_invite()
    {
        $friends   =   (isset($_REQUEST["ids"])   ?   $_REQUEST["ids"] : null);
        $nonFBfriends = (isset($_REQUEST["email_hashes"]) ? $_REQUEST["email_hashes"] : null);
        
        print_r($friends);
    }
}

/* End of file trips.php */
/* Location: ./application/controllers/trips.php */