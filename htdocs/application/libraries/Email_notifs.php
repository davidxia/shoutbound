<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_notifs
{
    public function get_emails_by_uid_setting($uids=array(), $setting_id=NULL)
    {
        if ( ! $setting_id)
        {
            return FALSE;
        }
        $emails = array();
        $u = new User();
        // get emails of users who want email notifications for trip invites
        foreach ($uids as $uid)
        {
            $u->get_by_id($uid);
            if ($u->check_notif_setting($setting_id))
            {
                $emails[] = $u->email;
            }
        }
        return $emails;
    }


    public function compose_email($user, $setting_id=NULL, $target=NULL)
    {
        if ( ! ($user->id AND $setting_id AND $target->id))
        {
            return FALSE;
        }
        switch($setting_id)
        {
            case 12:
                $subj = $user->name.' invited you to a trip on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound</h4>'.
                    '<a href="'.site_url('trips/'.$target->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.$target->name.'</a>'.
                    '<br/>'.$target->description.
                    '<br/>Have fun!<br/>Team Shoutbound';
                
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.$target->name.'</a>'.
                    '<br/>'.$target->description.
                    '<br/>Have fun!<br/>Team Shoutbound';
                break;
            case 13:
                $subj = $user->name.' shareddddddddddddddd you to a trip on Shoutbound';
                $html = '<h4><a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound</h4>'.
                    '<a href="'.site_url('trips/'.$target->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.$target->name.'</a>'.
                    '<br/>'.$target->description.
                    '<br/>Have fun!<br/>Team Shoutbound';
                
                $text = '<a href="'.site_url('profile/'.$user->id).'">'.$user->name.'</a> invited you to a trip on Shoutbound'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.
                    'To see the trip, click here.</a>'.
                    '<br/><a href="'.site_url('trips/'.$target->id).'">'.$target->name.'</a>'.
                    '<br/>'.$target->description.
                    '<br/>Have fun!<br/>Team Shoutbound';
                break;
            default:
                break;
        }

        return array($subj, $html, $text);
    }
        
    
    public function send_email($to_array=NULL, $subj=NULL, $html=NULL, $text=NULL, $setting_id=NULL, $from='notifications@shoutbound.com')
    {
        if ( ! ($to_array AND $subj AND $html AND $text AND $setting_id))
        {
            return FALSE;
        }
        
        $url = 'http://sendgrid.com/';
        $user = 'david@shoutbound.com';
        $pw = 'tEdRAmu6';
        switch($setting_id)
        {
            case 12:
                $category = 'trip invite';
                break;
            default:
                $category = 'uncategorized';
                break;
        }

        $json_string = array(
            'to' => $to_array,
            'category' => $category,
        );


        $params = array(
            'api_user'  => $user,
            'api_key'   => $pw,
            'x-smtpapi' => json_encode($json_string),
            'to'        => 'david@shoutbound.com',
            'subject'   => $subj,
            'html'      => $html,
            'text'      => $text,
            'from'      => $from,
        );

        $req =  $url.'api/mail.send.json';

        // Generate curl request
        $ch = curl_init($req);
        // Tell curl to use HTTP POST
        curl_setopt ($ch, CURLOPT_POST, TRUE);
        // Tell curl that this is the body of the POST
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // obtain response
        $r = curl_exec($ch);
        curl_close($ch);

        // print everything out
        //print_r($response);
        
        // return the JSON response
        return $r;
    }
}


/* End of file Email_notifs.php */
/* Location: ./system/libraries/Email_notifs.php */