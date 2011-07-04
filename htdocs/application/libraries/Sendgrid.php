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
        switch($this->email_type)
        {
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
        switch($this->email_type)
        {
            case 1:
                $subj = $source.' invited you to join Shoutbound';
                $html = $source. 'sent you an invite to check out Shoutbound';
                $text = $source. 'sent you an invite to check out Shoutbound';
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
                $this->sendgrid_cat = 'signup_invite';
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