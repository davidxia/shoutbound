<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		

    public function index($pid = FALSE)
    {
        $u = new User();
        $uid = $u->get_logged_in_status();

        // if user not logged in and no profile specified, return 404
        if ( ! ($pid OR $uid))
        {
            custom_404();
            return;
        }
        
        // if no profile number specified, show user's own profile
        if ( ! $pid)
        {
            $u->get_by_id($uid);
            $profile = $u->stored;
            $user = $u->stored;
            $pid = $uid;
        }
        elseif ( ! $uid)
        {
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            $user = FALSE;
        }
        // if profile specified and user's logged in
        else
        {
            $u->get_by_id($pid);
            if ( ! $u->id)
            {
                custom_404();
                return;
            }
            $profile = $u->stored;
            $u->get_by_id($uid);
            $user = $u->stored;

            if ($pid != $uid)
            {
                $u->related_user->where('id', $pid)->get();
                
                // get profile user's friendship status with this user
                $f = new User();
                $f->get_by_id($pid);
                $f->related_user->where('id', $uid)->get();
                
                if ( ! $u->related_user->id)
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
        }

        // get active trips for which profile is a planner or creator and rsvp is yes
        $trips = array();
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
            'user' => $user,
            'profile' => $profile,
            'trips' => $trips,
            'friends' => $friends,
            'is_friend' => $is_friend,
        );
        
        $this->load->view('profile/profile', $view_data);
    }
    
    
    public function edit()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid )
        {
            redirect('/');
        }
        
        $u->get_by_id($uid);
        
        $view_data = array(
            'user' => $u->stored,
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
            'user' => $u->stored,
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
        $places[] = $fbdata['location']['name'];
        $places[] = $fbdata['hometown']['name'];
        foreach ($fbdata['education'] as $education)
        {
            $places[] = $education['school']['name'];
        }
        foreach ($fbdata['work'] as $work)
        {
            $places[] = $work['location']['name'];
        }        
        $places = json_encode($places);
        print_r($places);
    }
    
    
    public function twitter_geohist()
    {
        $this->load->library('twitter');
        if (is_object($r = $this->twitter->authenticate()))
        {
            $tweets = $this->twitter->get($r->oauth_token, $r->oauth_token_secret, 'http://api.twitter.com/1/statuses/user_timeline.json', array('count'=>'200'));
            foreach ($tweets as $tweet)
            {
                if (isset($tweet->place))
                {
                    echo json_encode($tweet->place->bounding_box->coordinates[0]);
                }
            }
        }
        
    }
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */