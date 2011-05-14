<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
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
		

    public function index($pid = FALSE)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user->id)))
        {
            custom_404();
            return;
        }

        $u = new User();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $user = $this->user->stored;
            $pid = $this->user->id;
            $u->get_by_id($pid);
            $profile = $u->stored;
            $is_self = TRUE;
            $is_following = FALSE;
        }
        elseif ( ! isset($this->user->id))
        {
            $user = NULL;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            $is_self = FALSE;
            $is_following = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $user = $this->user->stored;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            
            // if profile is not user's own, check if he's following this other user
            if ($pid != $this->user->id)
            {
                $is_self = FALSE;
                $this->user->related_user->where('id', $pid)->include_join_fields()->get();
                if (isset($this->user->related_user->id) AND $this->user->related_user->join_is_following==1)
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
        
        // $profile is a reference to $u->stored, so weird!
        $u->get_recent_activities();
        $u->get_num_rsvp_yes_trips();
        $u->get_num_posts();
        $u->get_num_following();
        $u->get_num_following_trips();
        $u->get_num_followers();
        $u->get_first_name();
        
        $view_data = array(
            'user' => $user,
            'profile' => $profile,
            'is_self' => $is_self,
            'is_following' => $is_following,
        );

        $this->load->view('profile/index', $view_data);
    }
            
    
    public function trail($pid = FALSE)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user->id)))
        {
            custom_404();
            return;
        }

        $u = new User();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $user = $this->user->stored;
            $pid = $this->user->id;
            $u->get_by_id($pid);
            $profile = $u->stored;
            $is_self = TRUE;
        }
        elseif ( ! isset($this->user->id))
        {
            $user = NULL;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            $is_self = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $user = $this->user->stored;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;

            $is_self = ($pid == $this->user->id) ? TRUE : FALSE;
        }
        
        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $u->get_rsvp_yes_trips($user_id);
        $u->get_places();
        $data = array(
            'user' => $user,
            'profile' => $profile,
            'is_self' => $is_self,
        );

        $this->load->view('profile/trail', $data);
        //print_r($profile);
    }
    
    
    public function posts($pid = FALSE)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user->id)))
        {
            custom_404();
            return;
        }

        $u = new User();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $user = $this->user->stored;
            $pid = $this->user->id;
            $u->get_by_id($pid);
            $profile = $u->stored;
        }
        elseif ( ! isset($this->user->id))
        {
            $user = NULL;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        // if profile specified and user's logged in
        else
        {
            $user = $this->user->stored;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        
        if (isset($this->user->id))
        {
            $this->user->get_rsvp_yes_trips();
            $this->user->get_rsvp_awaiting_trips();
            $this->user->get_following_trips();
        }
        $u->get_posts();
        $data = array(
            'user' => $user,
            'profile' => $profile,
        );

        $this->load->view('profile/posts', $data);
    }
    
    
    public function following($pid = FALSE)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user->id)))
        {
            custom_404();
            return;
        }

        $u = new User();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $user = $this->user->stored;
            $pid = $this->user->id;
            $u->get_by_id($pid);
            $profile = $u->stored;
        }
        elseif ( ! isset($this->user->id))
        {
            $user = NULL;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        // if profile specified and user's logged in
        else
        {
            $user = $this->user->stored;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        
        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $u->get_following($user_id);
        $u->get_following_trips($user_id);
        $u->get_following_places($user_id);
        $view_data = array(
            'user' => $user,
            'profile' => $profile,
        );

        $this->load->view('profile/following', $view_data);
        //print_r($profile);
    }
    
    
    public function followers($pid = FALSE)
    {
        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR isset($this->user->id)))
        {
            custom_404();
            return;
        }

        $u = new User();
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $user = $this->user->stored;
            $pid = $this->user->id;
            $u->get_by_id($pid);
            $profile = $u->stored;
        }
        elseif ( ! isset($this->user->id))
        {
            $user = NULL;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        // if profile specified and user's logged in
        else
        {
            $user = $this->user->stored;
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
        }
        
        $user_id = (isset($this->user->id)) ? $this->user->id : NULL;
        $u->get_followers($user_id);
        $view_data = array(
            'user' => $user,
            'profile' => $profile,
        );

        $this->load->view('profile/followers', $view_data);
    }
        
    
    public function save_user_places()
    {
        $post = $this->input->post('places_dates');
        $post = $post['places_dates'];
        
        $p = new Place();
        foreach ($post as $key => $value)
        {
            //$p->clear();
            $p->get_by_id($post[$key]['place_id']);
            $this->user->save($p);
            
            // gets each place's date and stores as unix time
            $date = date_parse_from_format('n/j/Y', $post[$key]['date']);
            if (checkdate($date['month'], $date['day'], $date['year']))
            {
                $this->user->set_join_field($p, 'timestamp', strtotime($date['day'].'-'.$date['month'].'-'.$date['year']));
            }
        }
    }
    
    
    public function ajax_save_user_places()
    {
        $places = $this->input->post('places');
        //$places = json_decode($places);        
              
        $p = new Place();
        foreach ($places as $place)
        {
            //$p->clear();
            $p->get_by_id($place['placeId']);
            $this->user->save($p);
            
            // gets each place's date and stores as unix time
            $date = date_parse_from_format('n/j/Y', $place['date']);
            if (checkdate($date['month'], $date['day'], $date['year']))
            {
                $this->user->set_join_field($p, 'timestamp', strtotime($date['day'].'-'.$date['month'].'-'.$date['year']));
            }
        }
        json_success(array('places' => $places));
        //print_r($places);
    }
        
    
    public function ajax_save_profile()
    {
        $old_bio = $this->user->bio;
        $bio = $this->input->post('bio');
        $url = $this->input->post('url');
        
        $this->user->bio = $bio;
        $this->user->url = $url;
        if ($this->user->save())
        {
            json_success(array('bio' => $bio, 'url' => $url, 'response' => 'Saved.'));
        }
        else
        {
            json_error('something broke, tell David to fix');
        }
        
        if ($bio != $old_bio)
        {
            $this->load->helper('activity');
            save_activity($this->user->id, 9, TRUE, NULL, NULL, time()-72);
        }
        /*
        $p = new Place($this->input->post('currPlaceId'));
        
        if ($this->user->save($p))
        {
            $this->user->set_join_field($p, 'timestamp', time());
            json_success(array('bio' => $this->input->post('bio'), 'url' => $this->input->post('url'), 'currPlace' => $p->name));
        }
        else
        {
            json_error('something broke, tell David to fix');
        }
        */
    }
    
    
    public function profile_pic_uploadify()
    {
        if ( ! empty($_FILES)) {
            $uid = $this->input->post('uid');
            //$uid = $this->user->id;
          	$tempFile = $_FILES['Filedata']['tmp_name'];
          	list($width, $height, $type, $attr) = getimagesize($_FILES['Filedata']['tmp_name']);
          	
          	$targetPath = '/var/www/static/profile_pics/';
          	$targetFile =  str_replace('//','/',$targetPath) . $uid . '_' . $_FILES['Filedata']['name'];
    
        		$u = new User();
        		$u->get_by_id($uid);
        		$u->profile_pic = $uid . '_' . $_FILES['Filedata']['name'];
        		$u->save();
    
          	$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
          	$fileTypes  = str_replace(';','|',$fileTypes);
          	$typesArray = split('\|',$fileTypes);
          	$fileParts  = pathinfo($_FILES['Filedata']['name']);
          	
          	if (in_array($fileParts['extension'],$typesArray))
          	{
            		// Uncomment the following line if you want to make the directory if it doesn't exist
            		// mkdir(str_replace('//','/',$targetPath), 0755, true);
            		
            		move_uploaded_file($tempFile,$targetFile);
            		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
          	}
          	else
          	{
              echo 'Invalid file type.';
          	}
        }
    }
    
    
    public function ajax_edit_following()
    {
        $id = $this->input->post('profileId');
        $follow = $this->input->post('follow');
        $u = new User($id);
        
        if ($follow AND $u->id != $this->user->id)
        {
            $this->user->related_user->where('id', $u->id)->include_join_fields()->get();
            $new_follow = ($this->user->related_user->join_is_following == '0') ? FALSE : TRUE;
            if ($u->save($this->user))
            {
                $u->set_join_field($this->user, 'is_following', 1);
                if ($new_follow)
                {
                    $this->load->helper('activity');
                    save_activity($this->user->id, 3, $id, NULL, NULL, time()-72);
                    save_activity($u->id, 8, $this->user->id, NULL, NULL, time()-72);
                    
                    $this->load->library('email_notifs', array('setting_id' => 3, 'profile' => $u));
                    $this->email_notifs->get_emails();
                    $this->email_notifs->compose_email($this->user, $u->stored);
                    $this->email_notifs->send_email();
                }
                
                json_success(array('type' => 'user', 'id' => $id, 'follow' => $follow));
            }
            else
            {
                json_error('something broken, tell David');
            }
        }
        else
        {
            $u->set_join_field($this->user, 'is_following', 0);
            json_success(array('type' => 'user', 'id' => $id, 'follow' => $follow));
        }
    }
    
    
    public function history()
    {
        $view_data = array(
            'user' => $this->user,
        );

        $this->load->view('profile/history', $view_data);
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
        
        $view_data = array(
            'geodata' => $geodata,
        );
        
        $this->load->view('twitter_geohist', $view_data);
        
    }
    
    
    public function foursquare_geohist()
    {
        $this->load->library('epifoursquare');
        $clientId = 'ALCPEQ3OQEJ2WHTJOAPL0YWWYB4KMFFFVK5WHDMIF0YMROYZ';
        $clientSecret = 'OZC0TGXEGSSPDBPWTCSKVUOZFF3B1JA1AOR3GF5DXM5AU34R';
        
        $fsObj = new Epifoursquare($clientId, $clientSecret);
        $redirectUrl = 'http://dev.shoutbound.com/david/profile/foursquare_callback';
        $url = $fsObj->getAuthorizeUrl($redirectUrl);
        echo "<a href=\"$url\">Click here</a>";
        echo '<br/><br/>';
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
        foreach ($places as $place)
        {
            echo 'name: '.$place->name.', address: ', $place->location->address.', '.
                $place->location->city.', '.
                'distance: '.$place->location->distance.'<br/><br/>';
        }
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