<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendgrid
{
    public $email_type;
    private $user;
    private $user_ids;
    private $emails;
    
    private $email_subj;
    private $email_html;
    private $email_text;
    private $email_from = 'editor@shoutbound.com';
    private $email_fromname = 'Shoutbound';
    private $email_replyto = 'editor@shoutbound.com';

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
        switch($this->email_type)
        {
            case 1:
            case 80:
                $this->user->get_email();
                $this->emails[] = $this->user->email;
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
        if ( ! isset($user->id))
        {
            return FALSE;
        }
        switch($this->email_type)
        {
            case 1:
                $subj = 'Welcome to Shoutbound';
                $html = '<h1>Welcome to Shoutbound</h1>'.
                        'Make sure to add <strong>editor@shoutbound.com</strong> '.
                        'to your safe sender list or address book.'.
                        '<br/><br/>'.
                        '<a href="'.site_url('my_account/invite').'">Invite your friends</a> '.
                        'to Shoutbound and win prizes.'.
                        '<br/><br/>'.
                        '<a href="http://www.twitter.com/shoutbound">Twitter</a>'.
                        '<a href="http://www.facebook.com/shoutbound">Facebook</a>';
                $text = '<h1>Welcome to Shoutbound</h1>'.
                        'Make sure to add <strong>editor@shoutbound.com</strong> '.
                        'to your safe sender list or address book.'.
                        '<br/><br/>'.
                        '<a href="'.site_url('my_account/invite').'">Invite your friends</a> '.
                        'to Shoutbound and win prizes.'.
                        '<br/><br/>'.
                        '<a href="http://www.twitter.com/shoutbound">Twitter</a>'.
                        '<a href="http://www.facebook.com/shoutbound">Facebook</a>';
                break;
            case 2:
                $subj = $source.' invited you to sign up for Shoutbound';
                $html = $source.' sent you an invite to check out '.
                        '<a href="'.site_url('share/email_invite/'.$user->id).'">Shoutbound</a>';
                $text = $source.' sent you an invite to check out '.
                        '<a href="'.site_url('share/email_invite/'.$user->id).'">Shoutbound</a>';
                break;
            case 80:
                $subj = 'Shoutbound Password Reset';
                $html = 'We&rsquove received a request to reset your Shoutbound password.<br/> '.
                        'Please click <a href="'.site_url('login/reset_pw/'.$user->id.'/'.
                        $user->pw_reset_hash).'">this link</a> to reset your password '.
                        'or copy and paste the below into your browser:<br/>'.
                        site_url('login/reset_pw/'.$user->id.'/'.$user->pw_reset_hash).'<br/>'.
                        'This link works only once and will expire if not used. '.
                        'Please notify us if you did&rsquo;nt request a password reset.';
                $text = 'We&rsquove received a request to reset your Shoutbound password.<br/> '.
                        'Please click <a href="'.site_url('login/reset_pw/'.$user->id.'/'.
                        $user->pw_reset_hash).'">this link</a> to reset your password '.
                        'or copy and paste the below into your browser:<br/>'.
                        site_url('login/reset_pw/'.$user->id.'/'.$user->pw_reset_hash).'<br/>'.
                        'This link works only once and will expire if not used. '.
                        'Please notify us if you did&rsquo;nt request a password reset.';
                break;
            case 99:
                $subj = 'SHOUTBOUND BUG REPORT';
                $html = 'Description: '.$source.
                    '<br/>User ID: '.$user->id;
                $text = 'Description: '.$source.
                    '<br/>User ID: '.$user->id;
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
        $resp = json_decode($r);
        if ($resp->message == 'success')
        {
            return TRUE;
        }
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
            $this->email_type = $params;
        }
        elseif (is_array($params))
        {
            if (isset($params['email_type']))
            {
                $this->email_type = $params['email_type'];
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
        }
        
        // specify Sendgrid category
        switch($this->email_type)
        {
            case 1:
                $this->sendgrid_cat = 'welcome';
                break;
            case 2:
                $this->sendgrid_cat = 'signup_invite';
                break;
            case 80:
                $this->sendgrid_cat = 'password_reset';
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


/* End of file Sendgrid.php */
/* Location: ./system/libraries/Sendgrid.php */