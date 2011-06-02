<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trips extends CI_Controller
{
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
  	}
 	  

    public function index($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            redirect('/');
        }
        
        $trip = new Trip_m();
        //check if trip exists in trips table and is active
        $trip->get_by_id($trip_id);
        if ( ! $trip->is_active)
        {
            custom_404();
            return;
        }
        
        $trip->get_creator()
             ->get_num_goers()
             ->get_goers()
             ->get_num_followers()
             ->get_places()
             ->get_posts();
        
        if (isset($this->user))
        {
            // get user's relation to this trip
            $this->user
                ->get_rsvp_role_by_trip_id($trip_id)
                ->get_rsvp_yes_trips()
                ->get_rsvp_awaiting_trips()
                ->get_following_trips();
                        
            // if no relation, check if user has invite cookie with correct access key
            // redirect to home page if neither
            if ($trip->is_private AND ! $this->user->role AND ! $this->verify_share_cookie($trip_id))
            {
                custom_404();
                return;
            }
        }
        else
        {
            // if user is not logged in and no invite cookie
/*
            if ( ! $this->verify_share_cookie($trip_id))
            {
                if ($trip->is_private)
                {
                    custom_404();
                    return;
                }
*/
                //$this->user = new User_m();
                $this->user->role = 0;
                $this->user->rsvp = 0;
/*             } */
            // if user is not logged in but has invite cookie
/*
            else
            {
                $this->user->role = 5;
                $this->user->rsvp = 6;
            }
*/
        }
                
        $data = array(
            'trip' => $trip,
            'user' => $this->user,
        );
        $this->load->view('trip/index', $data);
    }
    
        
    public function followers($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            return;
        }
        
        $trip = new Trip_m($trip_id);
        if ( ! $trip->is_active)
        {
            return;
        }
        
        $user_id = (isset($this->user)) ? $this->user->id : FALSE;
        $trip->get_followers($user_id);
        
        $data = array(
            'trip' => $trip,
            'user' => $this->user,
        );
        $this->load->view('trip/followers', $data);
    }
    
    
    public function related_trips($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            return;
        }
        
        $trip = new Trip_m($trip_id);
        if ( ! $trip->is_active)
        {
            return;
        }

        $trip->get_related_trips();
              
        $data = array(
            'trip' => $trip,
        );
        $this->load->view('trip/related_trips', $data);
    }
    
        
    public function create($i = 1)
    {        
        $data = array(
            'user' => $this->user,
            'place' => $this->input->post('place_input'),
            'place_id' => $this->input->post('place_id'),
            'is_landing' => 1,
        );

        if ($i == 1)
        {
            $this->load->view('trip/create_with_map', $data);
        }
        elseif ($i == 2)
        {
            $this->load->view('trip/create', $data);
        }
        elseif ($i == 3)
        {
            $this->load->view('trip/create_three_steps', $data);
        }
        
    }
    
    
 	  public function confirm_create()
 	  {
        if ( !isset($this->user) OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        $post = $this->input->post('place_dates');
        $post = $post['place_dates'];
        
        $trip = new Trip_m();
        
        /*
        $deadline = date_parse_from_format('n/j/Y', $post['deadline']);
        {
            $t->response_deadline = mktime(0, 0, 0, $deadline['month'], $deadline['day'], $deadline['year']);
        }
        */
        //$t->is_private = ($post['private'] == 1) ? 1 : 0;
        
        // save trip's destinations and dates
        $places_dates = array();
        foreach ($post as $key => $val)
        {
            if (is_array($val))
            {
                $places_dates[$post[$key]['place_id']] = array();
                // gets each destination's startdate and enddate and stores as unix time
                $startdate = date_parse_from_format('n/j/Y', $post[$key]['startdate']);
                if (checkdate($startdate['month'], $startdate['day'], $startdate['year']))
                {
                    $places_dates[$post[$key]['place_id']]['startdate'] = strtotime($startdate['year'].'-'.$startdate['month'].'-'.$startdate['day']);
                }
                $enddate = date_parse_from_format('n/j/Y', $post[$key]['enddate']);
                if (checkdate($enddate['month'], $enddate['day'], $enddate['year']))
                {
                    $places_dates[$post[$key]['place_id']]['enddate'] = strtotime($enddate['year'].'-'.$enddate['month'].'-'.$enddate['day']);
                }
                
                // delete memcache of related trips
                $trip->get_related_trips();
                foreach ($trip->related_trips as $related_trip)
                {
                    $this->mc->delete('related_trip_ids_by_trip_id:'.$related_trip->id);
                }
            }
        }

        if ($trip->create(array(
            'name' => $post['trip_name'],
            'description' => $post['description'],
            'user_id' => $this->user->id,
            'places_dates' => $places_dates,
            )))
        {
            $this->load->model('Activity_m');
            $activity = new Activity_m();
            $activity->create(array('user_id' => $this->user->id, 'activity_type' => 1, 'source_id' => $trip->id));
            
            $params = array('setting_id' => 1, 'user' => $this->user);
            $this->load->library('email_notifs', $params);
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $trip);
            $this->email_notifs->send_email();
            
            redirect('trips/'.$trip->id);
        }
 	  }


    public function ajax_save_rsvp()
    {
        $trip_id = $this->input->post('tripId');
        $rsvp = $this->input->post('rsvp');

        if ( ! isset($this->user) OR !$trip_id OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        $this->user->get_rsvp_role_by_trip_id($trip_id);
        
        // if no prior relation, make user a follower
        if ( !isset($this->user->role))
        {
            $success = $this->user->set_rsvp_role_for_trip_id($trip_id, 3, 0);

            $this->load->model('Activity_m');
            $activity = new Activity_m();
            $activity->create(array('user_id' => $this->user->id, 'activity_type' => 4, 'source_id' => $trip_id));

            $trip = new Trip_m($trip_id);
            $params = array('setting_id' => 4, 'trip' => $trip);
            $this->load->library('email_notifs', $params);
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $rsvp, $trip);
            $this->email_notifs->send_email();
        }
        // if prior record exists in table trips_users
        // to be able to rsvp higher than 3, user must be a planner
        elseif ($rsvp <= 3 OR ($rsvp > 3 AND $this->user->role >= 5))
        {
            $success = $this->user->set_rsvp_role_for_trip_id($trip_id, $rsvp, $this->user->role);
            // send email notification to goers if rsvp changed to yes or no
            if ($success AND $this->user->role == 5 AND ($rsvp == 0 OR $rsvp == 9))
            {
                $trip = new Trip_m($trip_id);
                $params = array('setting_id' => 13, 'trip' => $trip);
                $this->load->library('email_notifs', $params);
                $this->email_notifs->get_emails();
                $this->user->get_email();
                $this->email_notifs->delete_email($this->user->email);
                $this->email_notifs->compose_email($this->user, $rsvp, $trip);
                $this->email_notifs->send_email();
            }
        }
        else
        {
            $success = FALSE;
        }
        
        if ($success)
        {
            $data = array('str' => json_success(array(
                'type' => 'trip',
                'id' => $trip_id,
                'userId' => $this->user->id,
                'profilePic' => $this->user->profile_pic,
                'rsvp' => $rsvp,
            )));
        }
        else
        {
            $data = array('str' => json_error());
        }
        $this->load->view('blank', $data);
    }
        
                
    public function delete($trip_id = FALSE)
    {
        if ( ! ($this->user OR $trip_id))
        {
            custom_404();
            return;
        }
        
        $trip = new Trip_m($trip_id);
        $success = $trip->delete($this->user->id);
        if ($success)
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
		    $trip_id = $this->input->post('tripId');
		    
		    if ( ! ($this->user AND $post_id AND $trip_id))
		    {
		        return FALSE;
		    }
		    
		    $post = new Post_m($post_id);
		    $success = $post->remove_by_trip_id_user_id($trip_id, $this->user->id);
        
		    if ($success)
		    {
            $data = array('str' => json_success(array('id' => $post_id)));
		    }
		    else
		    {
		        $data = array('str' => json_error('something broke, tell David'));
		    }
		    
		    $this->load->view('blank', $data);
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
    
    
/*
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
*/
    
    
    public function ajax_share_dialog()
    {
        if ( ! $this->user)
        {
            return FALSE;
        }
        
        // get users this user is following who aren't invited yet to this trip
        $trip = new Trip_m($this->input->post('tripId'));
        $trip->get_uninvited_users_by_user_id($this->user->id);
        
        $data = array(
            'trip' => $trip,
            'share_role' => $this->input->post('shareRole'),
        );
        
        $r = $this->load->view('trip/share_dialog', $data, TRUE);
        $data = array('str' => json_success(array('data' => $r)));
        $this->load->view('blank', $data);
    }


    public function ajax_share()
    {
        $trip_id = $this->input->post('tripId');
        $share_role = $this->input->post('shareRole');
        $rsvp = ($share_role==5) ? 6 : 0;
        $setting_id = ($share_role==5) ? 12 : NULL;
        $uids = ($this->input->post('uids')) ? $this->input->post('uids') : array();
        $nonuser_emails = ($this->input->post('emails')) ? $this->input->post('emails') : array();
        
        $trip = new Trip_m($trip_id);
        $user = new User_m();
        // save record in trips_users table
        foreach ($uids as $uid)
        {
            if ($user->get_by_id($uid)->set_rsvp_role_for_trip_id($trip_id, $rsvp, $share_role))
            {
                $this->mc->delete('uninvited_user_ids_by_trip_id_user_id:'.$trip_id.':'.$this->user->id);
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
        
        if ($share_role == 5)
        {
            // send emails to those who are invited
            $params = array('setting_id' => $setting_id, 'trip' => $trip, 'user_ids' => $uids, 'emails' => $nonuser_emails);
            $this->load->library('email_notifs', $params);
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $trip);
            $this->email_notifs->send_email();
            // send emails to those who already rsvped yes
            $this->email_notifs->set_params(array('setting_id' => 8, 'emails' => array()));
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $uids, $trip);
            $this->email_notifs->send_email();

            $data = array('str' => json_success(array('message' => 'Invitations sent.')));
        }
        else
        {
            $data = array('str' => json_success(array('message' => 'trip shared')));
        }
        
        $this->load->view('blank', $data);
    }
        
        
    public function ajax_share_success()
    {        
        $data = array(
            'message' => $this->input->post('message'),
        );
        
        $r = $this->load->view('trip/share_success', $data, TRUE);
        $data = array('str' => json_success(array('data' => $r)));
        $this->load->view('blank', $data);
    }
    
}

/* End of file trips.php */
/* Location: ./application/controllers/trips.php */