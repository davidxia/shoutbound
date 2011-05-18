<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trips extends CI_Controller
{
    
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u;
        }
		}
		         	  
 	  
 	  public function confirm_create()
 	  {
        if ( ! isset($this->user->id) OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        $post = $this->input->post('place_dates');
        $post = $post['place_dates'];

        $t = new Trip();
        $t->name = $post['trip_name'];
        $t->description = $post['description'];
        $t->created = time()-72;
        /*
        $deadline = date_parse_from_format('n/j/Y', $post['deadline']);
        {
            $t->response_deadline = mktime(0, 0, 0, $deadline['month'], $deadline['day'], $deadline['year']);
        }
        */
        //$t->is_private = ($post['private'] == 1) ? 1 : 0;

        if ($t->save() AND $this->user->save($t)
            AND $t->set_join_field($this->user, 'role', 10)
            AND $t->set_join_field($this->user, 'rsvp', 9))
        {
            // save trip's destinations and dates
            $p = new Place();
            foreach ($post as $key => $val)
            {
                if (is_array($val))
                {
                    $p->clear();
                    $p->get_by_id($post[$key]['place_id']);
                    $t->save($p);
                    // gets each destination's startdate and enddate and stores as unix time
                    // TODO: callback method for better client side validation?
                    $startdate = date_parse_from_format('n/j/Y', $post[$key]['startdate']);
                    if (checkdate($startdate['month'], $startdate['day'], $startdate['year']))
                    {
                        $t->set_join_field($p, 'startdate', strtotime($startdate['day'].'-'.$startdate['month'].'-'.$startdate['year']));
                    }
                    $enddate = date_parse_from_format('n/j/Y', $post[$key]['enddate']);
                    if (checkdate($enddate['month'], $enddate['day'], $enddate['year']))
                    {
                        $t->set_join_field($p, 'enddate', strtotime($enddate['day'].'-'.$enddate['month'].'-'.$enddate['year']));
                    }
                }
            }
            
            $this->load->helper('activity');
            save_activity($this->user->id, 1, $t->id, NULL, NULL, time()-72);
            // TODO: success callback to ensure all destinations were saved?
            redirect('trips/'.$t->id);
        }      
 	  }
 	  

    public function index($trip_id = FALSE)
    {
        if ( ! $trip_id)
        {
            redirect('/');
        }
        
        $t = new Trip();
        //check if trip exists in trips table and is active
        $t->get_by_id($trip_id);
        if ( ! $t->is_active)
        {
            custom_404();
            return;
        }
        
        $t->get_creator();
        $t->get_num_goers();
        $t->get_goers();
        $t->get_num_followers();
        $t->get_places();
        
        if (isset($this->user->id))
        {
            $user = $this->user->stored;
            // get user's relation to this trip
            $user_role = $this->user->get_role_by_tripid($trip_id);
            $user_rsvp = $this->user->get_rsvp_by_tripid($trip_id);
            $this->user->get_rsvp_yes_trips();
            $this->user->get_rsvp_awaiting_trips();
            $this->user->get_following_trips();
            
            // if no relation, check if user has invite cookie with correct access key
            // redirect to home page if neither
            if ($t->is_private AND ! $user_role AND ! $this->verify_share_cookie($trip_id))
            {
                custom_404();
                return;
            }
        }
        else
        {
            $user = NULL;
            // if user is not logged in and no invite cookie
            if ( ! $this->verify_share_cookie($trip_id))
            {
                if ($t->is_private)
                {
                    custom_404();
                    return;
                }
                
                $user_role = 0;
                $user_rsvp = 0;
            }
            // if user is not logged in but has invite cookie
            else
            {
                $user_role = 5;
                $user_rsvp = 6;
            }
        }
                
        $data = array(
            'trip' => $t->stored,
            'user' => $user,
            'user_role' => $user_role,
            'user_rsvp' => $user_rsvp,
            'posts' => $t->get_posts(),
        );
        
        $this->load->view('trip/index', $data);
    }
    
        
    public function followers($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            redirect('/');
        }
        
        $t = new Trip($trip_id);
        if ( ! $t->is_active)
        {
            custom_404();
            return;
        }
        $user_id = (isset($this->user->id)) ? $this->user->id : FALSE;
        $t->get_followers($user_id);
        $data = array(
            'trip' => $t->stored,
            'user' => $this->user,
        );
        
        $this->load->view('trip/followers', $data);
    }
    
    
    public function related_trips($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            redirect('/');
        }
        $t = new Trip($trip_id);
        if ( ! $t->is_active)
        {
            custom_404();
            return;
        }

        $t->get_related_trips();        
        $data = array(
            'trip' => $t->stored,
        );
        $this->load->view('trip/related_trips', $data);
    }
    
    
    public function create($i=1)
    {        
        $user = ($this->user) ? $this->user->stored : NULL;
        $view_data = array(
            'user' => $user,
            'place' => $this->input->post('place_input'),
            'place_id' => $this->input->post('place_id'),
            'is_landing' => 1,
        );

        if ($i == 1)
        {
            $this->load->view('trip/create_inputs_aligned', $view_data);
        }
        elseif ($i == 2)
        {
            $this->load->view('trip/create', $view_data);
        }
        elseif ($i == 3)
        {
            $this->load->view('trip/create_three_steps', $view_data);
        }
        
    }
    
    
    public function ajax_trip_create()
    {
        if ( ! ($this->user->id AND $this->input->post('tripName')))
        {
            custom_404();
            return;
        }

        $t = new Trip();
        $t->name = $this->input->post('tripName');
        if ($t->save() AND $this->user->save($t)
            AND $t->set_join_field($this->user, 'role', 10)
            AND $t->set_join_field($this->user, 'rsvp', 9))
        {
            json_success(array('tripId' => $t->id));
        }        
    }


    public function ajax_save_rsvp()
    {
        $trip_id = $this->input->post('tripId');
        if ( ! isset($this->user->id) OR !$trip_id OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        $t = new Trip($trip_id);
        $t->user->include_join_fields()->where('user_id', $this->user->id)->get();
        $role = $t->user->join_role;
        $rsvp = $this->input->post('rsvp');
        
        // if prior record exists in table trips_users
        if (isset($role))
        {
            if ($rsvp <= 3)
            {
                $t->set_join_field($this->user, 'rsvp', $rsvp);
                json_success(array(
                    'type' => 'trip',
                    'id' => $trip_id,
                    'userId' => $this->user->id,
                    'profilePic' => $this->user->profile_pic,
                    'rsvp' => $rsvp,
                ));
            }
            // to be able to rsvp higher than 3, user must be a planner
            elseif ($rsvp > 3 AND $role == 5)
            {
                $t->set_join_field($this->user, 'rsvp', $rsvp);
                json_success(array(
                    'type' => 'trip',
                    'id' => $trip_id,
                    'userId' => $this->user->id,
                    'profilePic' => $this->user->profile_pic,
                    'rsvp' => $rsvp,
                ));
            }
            else
            {
                json_error('something broken, tell David');
            }
            
            // send email notification if rsvp changed to yes or no
            if ($role==5 AND ($rsvp==0 OR $rsvp==9))
            {
                $params = array('setting_id' => 13, 'trip' => $t);
                $this->load->library('email_notifs', $params);
                $this->email_notifs->get_emails();
                $this->email_notifs->delete_email($this->user->email);
                $this->email_notifs->compose_email($this->user, $rsvp, $t->stored);
                $this->email_notifs->send_email();
            }
        }
        // if no prior relation, make user a follower
        elseif ($t->save($this->user))
        {
            $t->set_join_field($this->user, 'rsvp', 3);
            $this->load->helper('activity');
            if (save_activity($this->user->id, 4, $t->id, NULL, NULL, time()-72))
            {
                json_success(array(
                    'type' => 'trip',
                    'id' => $trip_id,
                    'userId' => $this->user->id,
                    'profilePic' => $this->user->profile_pic,
                    'rsvp' => $rsvp,
                ));
            }
            if ($rsvp == 3)
            {
                $params = array('setting_id' => 4, 'trip' => $t);
                $this->load->library('email_notifs', $params);
                $this->email_notifs->get_emails();
                $this->email_notifs->compose_email($this->user, $rsvp, $t->stored);
                $this->email_notifs->send_email();
            }
        }
        else
        {
            json_error('something broken, tell David');
        }
    }
        
                
    public function share($trip_id, $share_key)
    {        
        $ts = new Trip_share();
        $trip_share = $ts->get_tripshare_by_tripid_sharekey($trip_id, $share_key);

        // if cookie is set, append new key value pair, otherwise instantiate new stdclass object
        
        if ($trip_share AND $received_invites = get_cookie('received_invites'))
        {
            // unserialize from JSON
            $received_invites = json_decode($received_invites);
            $received_invites->{$trip_share->trip_id} = md5('alea iacta est'.$share_key);
        }
        elseif ($trip_share)
        {
            $received_invites = (object)array($trip_share->trip_id => md5('alea iacta est'.$share_key));
        }
        // serialize to JSON and set cookie
        $received_invites = json_encode($received_invites);
        set_cookie('received_invites', $received_invites, 1209600);
        
        redirect('/trips/'.$trip_id);
        
    }
    
    
    public function delete($trip_id = FALSE)
    {
        if ( ! ($this->user->id OR $trip_id))
        {
            custom_404();
            return;
        }
        
        $t = new Trip($trip_id);
        $is_deleted = $t->delete($trip_id, $this->user->id);
        if ($is_deleted)
        {
            redirect('/');
        }
        else
        {
            custom_404();
            return;
        }
    }
        

		public function ajax_delete_post()
		{
		    $post_id = $this->input->post('postId');
		    $t = new Trip($this->input->post('tripId'));
		    if (isset($this->user->id))
		    {
		        $t->get_role_by_user_id($this->user->id);
		    }
		    if ($t->stored->role == 10)
		    {
		        $r = $t->delete_post($post_id);
    		    if ($r)
    		    {
                json_success(array('id' => $post_id));
    		    }
    		    else
    		    {
    		        json_error('something broke, tell David');
    		    }
		    }
		}


    private function verify_share_cookie($trip_id)
    {
        $received_invites = json_decode(get_cookie('received_invites'));
        $share_key = (isset($received_invites->$trip_id)) ? $received_invites->$trip_id : FALSE;
        if ($share_key)
        {
            $ts = new Trip_share();
            $ts->where('trip_id', $trip_id)->get();
            
            foreach ($ts as $trip_share)
            {
                if (md5('alea iacta est'.$trip_share->share_key) == $share_key)
                {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
    
    
    public function ajax_share_dialog()
    {
        // get ids of those user is following
        $this->user->related_user->get();
        
        // get users already invited to this trip
        $t = new Trip($this->input->post('tripId'));
        foreach ($t->user->where_join_field($t, 'role >', 0)->get_iterated() as $user)
        {
            $trip_uids[] = $user->id;
        }
        $uninvited_followings = array();
        foreach ($this->user->related_user as $following)
        {
            if ( ! in_array($following->id, $trip_uids))
            {
                $uninvited_followings[] = $following->stored;
            }
        }
        
        $data = array(
            'uninvited_followings' => $uninvited_followings,
            'share_role' => $this->input->post('shareRole'),
        );
        
        $r = $this->load->view('trip/share_dialog', $data, TRUE);
        json_success(array('data' => $r));
    }


    public function ajax_share()
    {
        $trip_id = $this->input->post('tripId');
        $share_role = $this->input->post('shareRole');
        $setting_id = ($share_role==5) ? 12 : 20;
        $uids = ($this->input->post('uids')) ? $this->input->post('uids') : array();
        $nonuser_emails = ($this->input->post('emails')) ? $this->input->post('emails') : array();
        
        $t = new Trip($trip_id);
        $u = new User();
        // save record in trips_users table
        foreach ($uids as $uid)
        {
            $u->get_by_id($uid);
            if ($t->save($u))
            {
                $t->set_join_field($u, 'role', $share_role);
                $t->set_join_field($u, 'rsvp', 6);
            }
        }
        // not pretty - needed to get rid of empty strings
        foreach ($nonuser_emails as $key => $val)
        {
            if ( ! trim($val))
            {
                unset($nonuser_emails[$key]);
            }
        }

        $params = array('setting_id' => $setting_id, 'trip' => $t, 'user_ids' => $uids, 'emails' => $nonuser_emails);
        $this->load->library('email_notifs', $params);
        $this->email_notifs->get_emails();
        $this->email_notifs->compose_email($this->user, $t->stored);
        $this->email_notifs->send_email();

        if ($share_role == 5)
        {
            json_success(array('message' => 'Invitations sent.'));
        }
        elseif ($share_role == 0)
        {
            json_success(array('message' => 'trip shared'));
        }
        //json_success(array('tripId' => $trip_id, 'uids'=>$uids, 'emails'=>$emails, 'tripId'=>$trip_id, 'html'=>$html, 'text'=>$text, 'subj'=>$subj, 'resp'=>$resp));
    }
    
        
    public function ajax_share_success()
    {        
        $data = array(
            'message' => $this->input->post('message'),
        );
        
        $r = $this->load->view('trip/share_success', $data, TRUE);
        json_success(array('data' => $r));
    }
}

/* End of file trips.php */
/* Location: ./application/controllers/trips.php */