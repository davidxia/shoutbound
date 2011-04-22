<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trips extends CI_Controller
{
    
    public $user;
    
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
        //$uid = get_cookie('uid');
        
        $post = $this->input->post('destinations_dates');
        $post = $post['destinations_dates'];

        $t = new Trip();
        $t->name = $post['trip_name'];
        $t->description = $post['description'];
        /*
        $deadline = date_parse_from_format('n/j/Y', $post['deadline']);
        {
            $t->response_deadline = mktime(0, 0, 0, $deadline['month'], $deadline['day'], $deadline['year']);
        }
        */
        //$t->is_private = ($post['private'] == 1) ? 1 : 0;
                
        //$u = new User();
        //$u->get_by_id($this->user->id);

        if ($t->save() AND $this->user->save($t)
            AND $t->set_join_field($this->user, 'role', 10)
            AND $t->set_join_field($this->user, 'rsvp', 9))
        {
            // save trip's destinations and dates
            $p = new Place();
            foreach ($post as $key => $value)
            {
                if (is_array($value))
                {
                    $p->clear();
                    $p->name = $post[$key]['address'];
                    $p->lat = $post[$key]['lat'];
                    $p->lng = $post[$key]['lng'];
                    $p->save();
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
            // send emails to planners
            /*
            $this->load->library('sendgrid_email');
            $emails = explode(',', $post['invites']);
            foreach ($emails as $email)
            {
                // generate new share key for each e-mail address
                $ts = new Trip_share();
                $ts->trip_id = $t->id;
                $ts->share_role = 2;
                $ts->share_medium = 1;
                $ts->target_id = $email;
                $share_key = $ts->generate_share_key();

                $response = $this->sendgrid_email->send_mail(
                    array($email),
                    $this->user->name.' invited you on a trip on Shoutbound!',
                    '<h4>'.$this->user->name.
                        ' invited you to a trip on Shoutbound</h4>'.$post['description'].
                        '<br/><a href="'.site_url('trips/share/'.$t->id.'/'.$share_key).
                        '">To see the trip, click here.</a>'.
                        '<br/>Have fun!<br/>Team Shoutbound',
                    $this->user->name.
                        ' invited you to a trip on Shoutbound'.$post['description'].
                        '<br/><a href="'.site_url('trips/share/'.$t->id.'/'.$share_key).
                        '">To see the trip, click here.</a>'.
                        '<br/>Have fun!<br/>Team Shoutbound'
                );
            }
            */
            
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
        if ( ! $t->active)
        {
            custom_404();
            return;
        }
        
        if (isset($this->user->id))
        {
            $user = $this->user->stored;
            // get user's relation to this trip
            $user_role = $this->user->get_role_by_tripid($trip_id);
            $user_rsvp = $this->user->get_rsvp_by_tripid($trip_id);
            
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
                
        $view_data = array(
            'trip' => $t->stored,
            'creator' => $t->get_creator(),
            'destinations' => $t->get_places(),
            'user' => $user,
            'user_role' => $user_role,
            'user_rsvp' => $user_rsvp,
            'wallitems' => $t->get_wallitems(),
            'trip_goers' => $t->get_goers(),
        );
        
        $this->load->view('trip/trip', $view_data);
        //print_r($user_role);
    }
    
    
    public function create($i=1)
    {        
        $user = ($this->user) ? $this->user->stored : NULL;
        $view_data = array(
            'user' => $user,
            'destination' => $this->input->post('destination'),
            'destination_lat' => $this->input->post('destination_lat'),
            'destination_lng' => $this->input->post('destination_lng'),
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
        if ( ! isset($this->user->id) OR !$this->input->post('tripId') OR getenv('REQUEST_METHOD') == 'GET')
        {
            custom_404();
            return;
        }
        
        $t = new Trip();
        $t->get_by_id($this->input->post('tripId'));
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
                    'userId' => $this->user->id,
                    'profilePic' => $this->user->profile_pic,
                    'rsvp' => $rsvp,
                ));
            }
            else
            {
                echo 0;
            }
        }
        // if no prior relation, make user a follower
        elseif ($t->save($this->user))
        {
            $t->set_join_field($this->user, 'rsvp', 3);
            json_success(array(
                'userId' => $this->user->id,
                'profilePic' => $this->user->profile_pic,
                'rsvp' => $rsvp,
            ));
        }
        else
        {
            echo 0;
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
    
    
    public function delete($trip_id=FALSE)
    {
        if ( ! ($this->user->id OR $trip_id))
        {
            custom_404();
            return;
        }
        
        $t = new Trip();
        //check if trip exists in trips table and is active, ie not deleted
        $t->get_by_id($trip_id);
        if ( ! $t->active)
        {
            custom_404();
            return;
        }

        //check if user is the creator, redirect to home page otherwise
        $this->user->trip->include_join_fields()->get_by_id($trip_id);
        if ($this->user->trip->join_role != 10)
        {
            custom_404();
            return;
        }

        $t->where('id', $trip_id)->update('active', 0);
        redirect('/');
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
    
}

/* End of file trips.php */
/* Location: ./application/controllers/trips.php */