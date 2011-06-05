<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_notifs
{
    public $setting_id;
    private $user;
    private $user_ids;
    private $emails;
    private $trip;
    private $profile;
    
    private $email_subj;
    private $email_html;
    private $email_text;
    private $email_from = 'notifications@shoutbound.com';
    private $email_fromname = 'Shoutbound';
    private $email_replyto = 'noreply@shoutbound.com';

    // Sendgrid params
    private $sendgrid_url = 'http://sendgrid.com/api/mail.send.json';
    private $sendgrid_user = 'david@shoutbound.com';
    private $sendgrid_pw = 'tEdRAmu6';
    private $sendgrid_cat;
    

    public function __construct($params=NULL)
    {
        if ($params)
        {
            $this->set_params($params);
        }
    }
    
    
    public function get_emails()
    {
        switch($this->setting_id)
        {
            case 1:
            case 2:
            case 10:
         	      $this->user->get_followers();
                foreach ($this->user->followers as $follower)
                {
                    $follower->get_settings();
                    if ($follower->settings[$this->setting_id])
                    {
                        $follower->get_email();
                        $this->emails[] = $follower->email;
                    }
                }
                break;
            case 3:
                $this->profile->get_settings();
                if ($this->profile->settings[$this->setting_id])
                {
                    $this->profile->get_email();
                    $this->emails[] = $this->profile->email;
                }
            case 12:
                foreach ($this->user_ids as $user_id)
                {
                    // TODO: instantiate one $user and on each loop of get_by_id,
                    // unset $settings property from last loop
                    $user = new User_m();
                    $user->get_by_id($user_id)->get_settings();
                    if ($user->settings[$this->setting_id])
                    {
                        $user->get_email();
                        $this->emails[] = $user->email;
                    }
                }
                break;
            case 4:
            case 8:
            case 11:
            case 13:
                $this->trip->get_goers();
                foreach ($this->trip->goers as $goer)
                {
                    $goer->get_settings();
                    if ($goer->settings[$this->setting_id])
                    {
                        $goer->get_email();
                        $this->emails[] = $goer->email;
                    }
                }
                break;
            case 6:
                $user = new User_m($this->post->user_id);
                $user->get_settings();
                if ($user->settings[$this->setting_id])
                {
                    $user->get_email();
                    $this->emails[] = $user->email;
                }
                break;
            case 99:
                $this->emails[] = 'david@shoutbound.com';
                $this->emails[] = 'james@shoutbound.com';
                break;
        }
        return $this->emails;
    }
    
    
    public function compose_email($user, $source=NULL, $parent=NULL)
    {
        if ( ! isset($user->id) OR ! isset($source))
        {
            return FALSE;
        }
        switch($this->setting_id)
        {
            case 1:
                $subj = $user->name.' created a new trip "'.$source->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> created a new trip '.
                    '<a href="'.site_url('trips/'.$source->id).'">'.$source->name.'</a>.</h4>'.
                    '<br/>'.$source->description;
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> created a new trip '.
                    '<a href="'.site_url('trips/'.$source->id).'">'.$source->name.'</a>.'.
                    '<br/>'.$source->description;
                break;
            case 2:
                $subj = $user->name.' made a new post on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> wrote:</h4>'.
                    '<br/>'.$source->content.'<br/>'.
                    'on the following trips:';
                    foreach ($parent as $trip)
                    {
                        $html .= '<br/><a href="'.site_url('trips/'.$trip->id).'">'.$trip->name.'</a>';
                    }
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> wrote:'.
                    '<br/>'.$source->content.'<br/>'.
                    'on the following trips:';
                    foreach ($parent as $trip)
                    {
                        $text .= '<br/><a href="'.site_url('trips/'.$trip->id).'">'.$trip->name.'</a>';
                    }
                break;
            case 3:
                $subj = $user->name.' is now following you on Shoutbound';
                $html = '<div style="width:600px; font-family:Helvetica Neue, Helvetica, Arial, sans-serif; font-size:13px; line-height:19px; color:#333; padding:5px;">'.
                    '<div style="float:left; margin-right:10px; width:50px; height:50px; padding:3px; border:1px solid #DADADA;"><a href="'.site_url('profile/'.$user->id).'"><img src="'.static_sub('profile_pics/'.$user->profile_pic).'" height:50px; width:50px;/></a></div>'.                                
                    '<div><span style="font-size:14px"><a href="'.site_url('profile/'.$user->id).'"><strong>'.$user->name.'</strong></a> is now following you on Shoutbound.</span><br/><a href="'.site_url('profile/'.$user->id).'">Click here to view '.$user->name.'&rsquo;s profile</a></div>'.
                    '<div style="clear:both">'.
                    '<br/><br/><br/><br/>'.
                    '<div style="border-top:1px solid #888; color:#888; font-size:11px; line-height:18px;">To control when you receive e-mail notifications from Shoutbound, <a style="color:#888; "href="#">click here</a> to manage your account settings.</div>';                                
                $text = '<div style="width:600px; font-family:Helvetica Neue, Helvetica, Arial, sans-serif; font-size:13px; line-height:19px; color:#333; padding:5px;></div>'.                
                  '<div><span style="font-size:14px"><strong>'.$user->name.'</strong> is now following you on Shoutbound.</span><br/><a href="'.site_url('profile/'.$user->id).'">Click here to view '.$user->name.'&rsquo;s profile</a></div>'.
                  '<br/><br/><br/><br/>'.
                    '<div style="border-top:1px solid #888; color:#888; font-size:11px; line-height:18px;">To control when you receive e-mail notifications from Shoutbound, <a style="color:#888; "href="#">click here</a> to manage your account settings.</div>';                                
                break;
            case 4:
                $subj = $user->name.' is now following your trip "'.$parent->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> is now following '.
                    'your trip "<a href="'.site_url('profile/'.$parent->id).'">'.$parent->name.'</a>" on Shoutbound.</h4>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> is now following '.
                    'your trip "<a href="'.site_url('profile/'.$parent->id).'">'.$parent->name.'</a>" on Shoutbound.';
                break;    
            case 6:
                $subj = $user->name.' commented on your post on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> commented:</h4>'.
                    $source->content.'<br/><br/>'.
                    'in response to your post:<br/>'.
                    $parent->content;
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> commented:<br/>'.
                    $source->content.'<br/><br/>'.
                    'in response to your post:<br/>'.
                    $parent->content;
                break;    
            case 8:
                $subj = $user->name.' invited more people to your trip "'.$parent->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited the following people to your trip'.
                    '"<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'</a>" on Shoutbound:</h4><br/>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited the following people to your trip'.
                    '"<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'</a>" on Shoutbound:<br/>';
                $user = new User_m();
                foreach ($source as $user_id)
                {
                    $user->get_by_id($user_id);
                    $html .= '<a href="'.site_url('profile/'.$user->id).'">'.
                        '<img src="'.static_sub('profile_pics/'.$user->profile_pic).'"/></a>'.
                        '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a>'.
                        $user->bio.'<br/>';
                    $text .= '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a>'.
                    $user->bio.'<br/>';
                }
                $html .= '<br/>'.$parent->description;
                $text .= '<br/>'.$parent->description;
                    
                break;
            case 10:
                $subj = $user->name.' changed current location to "'.$source->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> changed current location to '.
                    '<a href="'.site_url('places/'.$source->id).'">'.$source->name;
                    if ($source->admin1) $html .= ', '.$source->admin1;
                    if ($source->country) $html .= ', '.$source->country;
                    '</a>.</h4>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> wrote on '.
                    '<a href="'.site_url('places/'.$source->id).'">'.$source->name;
                    if ($source->admin1) $text .= ', '.$source->admin1;
                    if ($source->country) $text .= ', '.$source->country;
                    '</a>.';
                break;
            case 11:
                $subj = $user->name.' posted on your trip "'.$parent->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> wrote on '.
                    '<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'</a>:</h4>'.
                    '<br/>'.$source->content;
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> wrote on '.
                    '<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'</a>:'.
                    '<br/>'.$source->content;
                break;
            case 12:
                $subj = $user->name.' invited you to a trip on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound</h4>'.
                    '<a href="'.site_url('trips/'.$source->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$source->id).'">'.$source->name.'</a>'.
                    '<br/>'.$source->description;
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound'.
                    '<br/><a href="'.site_url('trips/'.$source->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$source->id).'">'.$source->name.'</a>'.
                    '<br/>'.$source->description;
                break;
            case 13:
                if ($source == 0)
                {
                    $rsvp = 'no';
                }
                elseif ($source == 9)
                {
                    $rsvp = 'yes';
                }
                $subj = $user->name.' RSVP\'d '.$rsvp.' to your trip "'.$parent->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> RSVP\'d '.$rsvp.
                    ' to your trip "<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'"</a></h4>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> RSVP\'d '.$rsvp.
                    ' to your trip "<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'"</a>';
                break;
            case 99:
                $subj = 'SHOUTBOUND BUG REPORT';
                $html = 'Description: '.$source.
                    '<br/>User ID: '.$user->id.
                    '<br/>User name: '.$user->name;
                $text = 'Description: '.$source.
                    '<br/>User ID: '.$user->id.
                    '<br/>User name: '.$user->name;
                break;
            default:
                break;
        }

        $this->email_subj = $subj;
        $this->email_html = $html;
        $this->email_text = $text;
    }
        
    
    public function send_email()
    {
        if ( ! ($this->emails AND $this->email_subj AND $this->email_html AND $this->email_text))
        {
            return FALSE;
        }
        
        $json_string = array(
            'to' => $this->emails,
            'category' => $this->sendgrid_cat,
        );
        $params = array(
            'api_user'  => $this->sendgrid_user,
            'api_key'   => $this->sendgrid_pw,
            'x-smtpapi' => json_encode($json_string),
            'to'        => 'david@shoutbound.com',
            'subject'   => $this->email_subj,
            'html'      => $this->email_html,
            'text'      => $this->email_text,
            'from'      => $this->email_from,
            'fromname'  => $this->email_fromname,
            'replyto'   => $this->email_replyto,
        );

        $ch = curl_init($this->sendgrid_url);
        curl_setopt ($ch, CURLOPT_POST, TRUE);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $r = curl_exec($ch);
        curl_close($ch);
        // return Sendgrid's JSON response
        return $r;
    }
    
    
    public function clear_emails()
    {
        $this->emails = array();
    }
    
    
    public function delete_email($email)
    {
        $keys = array_keys($this->emails, $email);
        foreach ($keys as $k)
        {
            unset($this->emails[$k]);
        }
    }
        
    
    public function set_params($params = NULL)
    {
        if (is_int($params))
        {
            $this->setting_id = $params;
        }
        elseif (is_array($params))
        {
            if (isset($params['setting_id']))
            {
                $this->setting_id = $params['setting_id'];
            }
            
            if (isset($params['user']))
            {
                $this->user = $params['user'];
            }
            
            if (isset($params['user_ids']))
            {
                $this->user_ids = $params['user_ids'];
            }
            else
            {
                $this->user_ids = array();
            }
            
            if (isset($params['emails']))
            {
                $this->emails = $params['emails'];
            }
            else
            {
                $this->emails = array();
            }
            
            if (isset($params['trip']))
            {
                $this->trip = $params['trip'];
            }
            
            if (isset($params['profile']))
            {
                $this->profile = $params['profile'];
            }
            
            if (isset($params['post']))
            {
                $this->post = $params['post'];
            }
        }
        
        // specify Sendgrid category
        switch($this->setting_id)
        {
            case 1:
                $this->sendgrid_cat = 'following_creates';
                break;
            case 2:
                $this->sendgrid_cat = 'following_posts';
                break;
            case 3:
                $this->sendgrid_cat = 'follows_user';
                break;
            case 4:
                $this->sendgrid_cat = 'follows_trip';
                break;
            case 6:
                $this->sendgrid_cat = 'post_comment';
                break;
            case 8:
                $this->sendgrid_cat = 'sent_invites';
                break;
            case 10:
                $this->sendgrid_cat = 'following_changed_curr_loc';
                break;
            case 11:
                $this->sendgrid_cat = 'trip_post';
                break;
            case 12:
                $this->sendgrid_cat = 'trip_invite';
                break;
            case 13:
                $this->sendgrid_cat = 'got_rsvp';
                break;
            case 99:
                $this->sendgrid_cat = 'bug_report';
                break;
            default:
                $this->sendgrid_cat = 'uncategorized';
                break;
        }
    }
}


/* End of file Email_notifs.php */
/* Location: ./system/libraries/Email_notifs.php */