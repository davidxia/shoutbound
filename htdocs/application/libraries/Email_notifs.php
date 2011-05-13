<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_notifs
{
    public $setting_id;
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
    

    public function __construct($params)
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
        }
        
        // specify Sendgrid category
        switch($this->setting_id)
        {
            case 3:
                $this->sendgrid_cat = 'follows_user';
                break;
            case 11:
                $this->sendgrid_cat = 'trip_post';
            case 12:
                $this->sendgrid_cat = 'trip_invite';
                break;
            case 13:
                $this->sendgrid_cat = 'got_rsvp';
                break;
            default:
                $this->sendgrid_cat = 'uncategorized';
                break;
        }
    }
    
    
    public function get_emails()
    {
        switch($this->setting_id)
        {
            case 3:
                if ($this->profile->check_notif_setting($this->setting_id))
                {
                    $this->emails[] = $this->profile->email;
                }
            case 12:
                $u = new User();
                foreach ($this->user_ids as $user_id)
                {
                    $u->get_by_id($user_id);
                    if ($u->check_notif_setting($this->setting_id))
                    {
                        $this->emails[] = $u->email;
                    }
                }
                break;
            case 11:
            case 13:
                $u = new User();
                $this->trip->get_goers();
                foreach ($this->trip->stored->goers as $goer)
                {
                    $u->get_by_id($goer->id);
                    if ($u->check_notif_setting($this->setting_id))
                    {
                        $this->emails[] = $goer->email;
                    }
                }
                break;
        }
    }
    
    
    public function compose_email($user, $source=NULL, $parent=NULL)
    {
        if ( ! isset($user->id) OR ! isset($source))
        {
            return FALSE;
        }
        switch($this->setting_id)
        {
            case 3:
                $subj = $user->name.' is now following you on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> is now following '.
                    '<a href="'.site_url('profile/'.$source->id).'">you</a> on Shoutbound.</h4>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> is now following '.
                    '<a href="'.site_url('profile/'.$source->id).'">you</a> on Shoutbound.';
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
                } elseif ($source == 9)
                {
                    $rsvp = 'yes';
                }
                $subj = $user->name.' RSVP\'d '.$rsvp.' to your trip "'.$parent->name.'" on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> RSVP\'d '.$rsvp.
                    ' to your trip "<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'"</a></h4>';
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> RSVP\'d '.$rsvp.
                    ' to your trip "<a href="'.site_url('trips/'.$parent->id).'">'.$parent->name.'"</a>';
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
        

    public function set_trip($trip)
    {
        $this->trip = $trip;
    }
}


/* End of file Email_notifs.php */
/* Location: ./system/libraries/Email_notifs.php */