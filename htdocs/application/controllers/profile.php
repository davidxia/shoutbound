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
            $this->user = $u->stored;
        }
		}
		

    public function index($pid = FALSE)
    {
        //$u = new User();
        //$uid = $u->get_logged_in_status();

        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR $this->user))
        {
            custom_404();
            return;
        }
        
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            //$u->get_by_id($uid);
            $profile = $this->user;
            //$user = $this->user;
            $pid = $this->user->id;
            $is_friend = -1;
        }
        elseif ( ! $this->user)
        {
            $u = new User();
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            $is_friend = -1;
            //$user = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $u = new User();
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            //$u->get_by_id($uid);
            //$user = $this->user;

            if ($pid != $this->user->id)
            {
                $u->get_by_id($this->user->id);
                $u->related_user->where('id', $pid)->get();
                
                // get profile user's friendship status with this user
                $f = new User();
                $f->get_by_id($pid);
                $f->related_user->where('id', $this->user->id)->get();

                if ( ! isset($u->related_user->id))
                {
                    $is_friend = 0;
                }
                elseif ($u->related_user->id AND ! $f->related_user->id)
                {
                    $is_friend = 1;
                }
                elseif ($u->related_user->id AND $f->related_user->id)
                {
                    $is_friend = 2;
                }
            }
            else
            {
                $is_friend = -1;
            }
        }

        // get active trips for which profile is a planner or creator and rsvp is yes
        $trips = array();
        $u = new User();
        $u->get_by_id($pid);

        $u->trip->where('active', 1)->where_in_join_field('user', 'role', array(2,3))->where_join_field('user', 'rsvp', 3)->get();
        foreach ($u->trip as $trip)
        {
            // get trip's destinations
            $d = new Destination();
            $d->where('trip_id', $trip->id)->get();
            $trip->stored->destinations = array();
            foreach ($d->all as $destination)
            {
                $trip->stored->destinations[] = $destination->stored;
            }

            $trips[] = $trip->stored;
        }
        
        // get profile's Shoutbound friends (we shouldn't display their FB friends publicly)
        $friends = array();
        // get array of friends relations to the user
        $u->user->get();
        $rels_to = array();
        foreach ($u->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
        }
        // get array of friend relations from the user
        // TODO: is there a better way of doing this? like with a 'where' clause in one datamapper call?
        $u->related_user->get();
        $rels_from = array();
        foreach ($u->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
        }
        $friend_ids = array_intersect($rels_to, $rels_from);
        
        foreach ($friend_ids as $friend_id)
        {
            $u->get_by_id($friend_id);
            $friends[] = $u->stored;
        }
        
        $view_data = array(
            'user' => $this->user,
            'profile' => $profile,
            'trips' => $trips,
            'friends' => $friends,
            'is_friend' => $is_friend,
        );
        
        $this->load->view('profile/profile', $view_data);
    }
    
    
    public function edit()
    {
        //$u = new User();
        //$uid = $u->get_logged_in_status();
        if ( ! $this->user)
        {
            custom_404();
            return;
        }
        
        //$u->get_by_id($uid);
        
        $view_data = array(
            'user' => $this->user,
        );
 			               
        $this->load->view('profile/edit', $view_data);
    }
    
    
    public function profile_pic_uploadify()
    {
        if ( ! empty($_FILES)) {
            $uid = $this->input->post('uid');
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
        $res = $fsObj->get('/users/self/checkins');
        $checkins = $res->response->checkins->items;
        
        foreach ($checkins as $checkin)
        {
            echo $checkin->venue->name.' '.
                $checkin->createdAt.' '.
                $checkin->venue->location->lat.' '.
                $checkin->venue->location->lng.'<br/><br/>';
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
            //'has_geo' => '1',
            'lat' => '-9.1',
            'lon' => '-75',
            //'is_getty' => '1',
        );
        
        $results = $f->photos_search($args);
        print_r($results);
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