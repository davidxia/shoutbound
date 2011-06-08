<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
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
  	    

    public function index($pid = NULL)
    {
        // if no profile specified, return 404
        if ( ! $pid)
        {
            custom_404();
            return;
        }

        $profile = new User_m();
        if (is_numeric($pid))
        {
            $profile->get_by_id($pid);
        }
        else
        {
            $profile->get_by_username($pid);
        }
        
        if ( ! $profile->id)
        {
            custom_404();
            return;
        }
        
        if ( ! isset($this->user))
        {
            $is_self = FALSE;
            $is_following = FALSE;
        }
        else
        {
            // if profile is not user's own, check if he's following this other user
            if ($profile->id != $this->user->id)
            {
                $is_self = FALSE;
                $profile->get_follow_status_by_user_id($this->user->id);
                if ($profile->is_following == 1)
                {
                    $is_following = TRUE;
                }
                else
                {
                    $is_following = FALSE;
                }
            }
            else
            {
                $is_self = TRUE;
                $is_following = FALSE;
            }
        }
        
        $profile->get_recent_activity()
          ->get_num_rsvp_yes_trips()
          ->get_num_posts()
          ->get_num_following_users()
          ->get_num_following_trips()
          ->get_num_following_places()
          ->get_num_followers()
          ->get_first_name()
          ->get_current_place()
          ->get_future_places()
          ->get_past_places();
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
            'is_self' => $is_self,
            'is_following' => $is_following,
        );

        $this->load->view('profile/index', $data);
    }


    public function trips($pid = NULL)
    {
        if ( ! $pid)
        {
            return;
        }

        $profile = new User_m();
        if (is_numeric($pid))
        {
            $profile->get_by_id($pid);
        }
        else
        {
            $profile->get_by_username($pid);
        }
        
        if ( ! $profile->id)
        {
            return;
        }

        if ( ! isset($this->user))
        {
            $is_self = FALSE;
        }
        else
        {
            $is_self = ($profile->id == $this->user->id) ? TRUE : FALSE;
        }
        
        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $profile->get_rsvp_yes_trips($user_id)
          ->get_future_places()
          ->get_current_place()
          ->get_past_places()
          ->get_first_name();

          
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
            'is_self' => $is_self,
        );

        $this->load->view('profile/trips', $data);
    }


    public function posts($pid = NULL)
    {
        if ( ! $pid)
        {
            return;
        }

        $profile = new User_m();
        if (is_numeric($pid))
        {
            $profile->get_by_id($pid);
        }
        else
        {
            $profile->get_by_username($pid);
        }
        
        if ( ! $profile->id)
        {
            return;
        }
        
        if (isset($this->user))
        {
            $this->user->get_rsvp_yes_trips();
            $this->user->get_rsvp_awaiting_trips();
            $this->user->get_following_trips();
        }
        $profile->get_posts()->get_first_name();
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
        );
        $this->load->view('profile/posts', $data);
    }
    

    public function following($pid = NULL)
    {
        if ( ! $pid)
        {
            return;
        }

        $profile = new User_m();
        if (is_numeric($pid))
        {
            $profile->get_by_id($pid);
        }
        else
        {
            $profile->get_by_username($pid);
        }
        
        if ( ! $profile->id)
        {
            return;
        }

        $user_id = (isset($this->user)) ? $this->user->id : NULL;
        $profile->get_following_users($user_id);
        $profile->get_following_trips($user_id);
        $profile->get_following_places($user_id);
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
        );

        $this->load->view('profile/following', $data);
    }


    public function followers($pid = NULL)
    {
        if ( ! $pid)
        {
            return;
        }

        $profile = new User_m();
        if (is_numeric($pid))
        {
            $profile->get_by_id($pid);
        }
        else
        {
            $profile->get_by_username($pid);
        }
        
        if ( ! $profile->id)
        {
            return;
        }

        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $profile->get_followers($user_id);
        
        $data = array(
            'user' => $this->user,
            'profile' => $profile,
        );

        $this->load->view('profile/followers', $data);
    }
    

    public function profile_pic_uploadify()
    {
        if ( ! empty($_FILES))
        {
            $uid = $this->input->post('uid');
            $this->user = new User_m($uid);
            
          	$tempFile = $_FILES['Filedata']['tmp_name'];
          	list($width, $height, $type, $attr) = getimagesize($_FILES['Filedata']['tmp_name']);
          	
          	$targetPath = '/var/www/static/profile_pics/';
          	$targetFile =  str_replace('//','/',$targetPath).$uid.'_'.$_FILES['Filedata']['name'];
    
          	$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
          	$fileTypes  = str_replace(';','|',$fileTypes);
          	$typesArray = split('\|',$fileTypes);
          	$fileParts  = pathinfo($_FILES['Filedata']['name']);
          	
          	if (in_array($fileParts['extension'],$typesArray))
          	{
            		// Uncomment the following line if you want to make the directory if it doesn't exist
            		// mkdir(str_replace('//','/',$targetPath), 0755, true);
            		move_uploaded_file($tempFile,$targetFile);
            		if ($this->user->set_profile_info(array('profile_pic' => $uid.'_'.$_FILES['Filedata']['name'])))
            		{
                		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
            		}
            		
          	}
          	else
          	{
                echo 'Invalid file type';
          	}
        }
    }


    public function ajax_edit_following()
    {
        $profile_id = $this->input->post('profileId');
        $follow = $this->input->post('follow');
        $profile = new User_m($profile_id);
        
        if ($follow AND $profile->id != $this->user->id)
        {
            $profile->get_follow_status_by_user_id($this->user->id);
            $new_follow = (isset($profile->is_following)) ? FALSE : TRUE;
            $num_affected = $this->user->set_follow_for_user_id($profile->id, $follow);
            
            if ($num_affected == 1 OR $num_affected == 2)
            {
                if ($new_follow)
                {
                    $this->load->model('Activity_m');
                    $a = new Activity_m();
                    if ($a->create(array('user_id' => $this->user->id, 'activity_type' => 3, 'source_id' => $profile->id)))
                    {
                        $a->create(array('user_id' => $profile->id, 'activity_type' => 8, 'source_id' => $this->user->id));
                    }
                    
                    $this->load->library('email_notifs', array('setting_id' => 3, 'profile' => $profile));
                    $this->email_notifs->get_emails();
                    $this->email_notifs->compose_email($this->user, $profile);
                    $this->email_notifs->send_email();
                }
                
                $data = array('str' => json_success(array('type' => 'user', 'id' => $profile->id, 'follow' => $follow)));
            }
            else
            {
                $data = array('str' => json_error('something broken, tell David'));
            }
        }
        elseif ( ! $follow)
        {
            $this->user->set_follow_for_user_id($profile->id, $follow);
            $data = array('str' => json_success(array('type' => 'user', 'id' => $profile->id, 'follow' => $follow)));
        }
        
        $this->load->view('blank', $data);
    }


    public function ajax_save_user_places()
    {
        if ( !$this->user OR !$this->input->post('placesDates'))
        {
            return;
        }

        $places_dates = $this->input->post('placesDates');
        foreach ($places_dates as $place_date)
        {
            if ($place_date['placeId'])
            {
                $date = date_parse_from_format('m/Y', $place_date['date']);
                if (checkdate($date['month'], 1, $date['year']))
                {
                    $timestamp = strtotime($date['year'].'-'.$date['month'].'-01');
                }
                else
                {
                    $timestamp = NULL;
                }
                $this->user->set_past_place($place_date['placeId'], $timestamp);
            }
        }
        
        $data = array('str' => json_success(array('response' => 'saved')));
    }


    public function history()
    {
        $data = array(
            'user' => $this->user,
        );

        $this->load->view('profile/history', $data);
    }
    
    
    public function facebook_geohist()
    {
        $this->load->library('facebook');
        $fbdata = $this->facebook->api('/me?fields=name,location,hometown,education,work');
        
        $checkins = $this->facebook->api(array(
            'method' => 'fql.query',
            'query' => 'SELECT coords FROM checkin WHERE author_uid = me()'
        ));
        //print_r($checkins); echo '<br/><br/>';
        
        
        $places = array();
        if ($fbdata['location']['name'])
        {
            $places[] = $fbdata['location']['name'];
        }
        if ($fbdata['hometown']['name'])
        {
            $places[] = $fbdata['hometown']['name'];
        }
        if ($fbdata['education'])
        {
            foreach ($fbdata['education'] as $education)
            {
                $places[] = $education['school']['name'];
            }        
        }
        if ($fbdata['work'])
        {
            foreach ($fbdata['work'] as $work)
            {
                $places[] = $work['location']['name'];
            }
        }
        echo json_encode($places);
    }
    
    
    public function twitter_geohist()
    {
        $this->load->library('twitter');
        if (is_object($r = $this->twitter->authenticate()))
        {
            // TODO: store access token somewhere so we don't have to get new one everytime??
            $tweets = $this->twitter->get($r->oauth_token, $r->oauth_token_secret, 'http://api.twitter.com/1/statuses/user_timeline.json', array('count'=>'200'));
            foreach ($tweets as $tweet)
            {
                if (isset($tweet->place))
                {
                    $geodata = json_encode($tweet->place->bounding_box->coordinates[0]);
                }
            }
        }
        
        $data = array(
            'geodata' => $geodata,
        );
        
        $this->load->view('twitter_geohist', $data);
        
    }
    
    
    public function foursquare_geohist()
    {
        $this->load->library('epifoursquare');
        $clientId = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
        $clientSecret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
        
        $fsObj = new Epifoursquare($clientId, $clientSecret);
        $redirectUrl = 'http://dev.shoutbound.com/david/profile/foursquare_callback';
        $url = $fsObj->getAuthorizeUrl($redirectUrl);
        
        $data = array('str' => '<a href="'.$url.'">Click here</a>');
        $this->load->view('blank', $data);
    }
    
    
    public function foursquare_callback()
    {
        $this->load->library('epifoursquare');
        $clientId = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
        $clientSecret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
        $redirectUrl = 'http://dev.shoutbound.com/david/profile/foursquare_callback';

        $fsObj = new Epifoursquare($clientId, $clientSecret);
        // exchange the request token for an access token
        $token = $fsObj->getAccessToken($_GET['code'], $redirectUrl);
        //print_r($token).'<br/><br/>';
        // you can store $token->access_token in your database
        $fsObj->setAccessToken($token->access_token);
        /*
        $res = $fsObj->get('/users/self/checkins');
        $checkins = $res->response->checkins->items;
        
        foreach ($checkins as $checkin)
        {
            echo $checkin->venue->name.' '.
                $checkin->createdAt.' '.
                $checkin->venue->location->lat.' '.
                $checkin->venue->location->lng.'<br/><br/>';
        }
        */
        // try to get place data from foursquare
        $params = array(
            'll'=>'40.71,-74.01',
            'query'=>'ace hotel',
        );
        
        $res = $fsObj->get('/venues/search', $params);
        $places = $res->response->groups[0]->items;
        $data = array('str' => '');
        foreach ($places as $place)
        {
            $data['str'] .= 'name: '.$place->name.', address: '. $place->location->address.', '.
                $place->location->city.', '.
                'distance: '.$place->location->distance.'<br/><br/>';
        }
        $this->load->view('blank', $data);
    }
    
    
    public function flickr_test()
    {
        $params = array(
            'api_key' => 'd78a7c1d0670efe5f00cbf953251f50f',
            'secret' => 'd081991f6eb0f0e2',
            'die_on_error' => 'false'
        );
        
        $this->load->library('phpflickr', $params);
        
        $f = new phpFlickr('d78a7c1d0670efe5f00cbf953251f50f');
        /*
        $recent = $f->photos_getRecent();
        //print_r($recent);
        
        $photo = $recent['photos']['photo'][0];
        $owner = $f->people_getInfo($photo['owner']);
        echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
        echo $photo['title'];
        echo "</a> Owner: ";
        echo "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>";
        echo $owner['username'];
        echo "</a><br>";
        */
        $args = array(
            'has_geo' => '1',
            'lat' => '40.75058',
            'lon' => '-73.99358000000001',
            //'is_getty' => '1',
        );
        
        $results = $f->photos_search($args);
        //print_r($results);
        foreach ($results['photo'] as $photo)
        {
            echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
            echo $photo['title'];
            echo '<br/>';
        }
    }
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */