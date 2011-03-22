<?php

class Trip_shares extends Controller
{
    
    function Trip_shares()
    {
        parent::Controller();
    }
    
    
    function generate_share_key($trip_id, $share_role, $share_medium, $target_id, $is_claimed)
    {
        $u = new User();
        if ( ! $u->get_logged_in_status() OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');            
        }

        $ts = new Trip_share();
        $ts->trip_id = $trip_id;
        $ts->share_role = $share_role;
        $ts->share_medium = $share_medium;
        $ts->target_id = $target_id;
        $ts->is_claimed = $is_claimed;

        $share_key = $ts->generate_share_key();
        
        if ($share_key)
        {
            json_success(array('shareKey' => $share_key));
        }
        else
        {
            json_error('something broke, tell David to fix it');
        }
    }
    
    
    function send_email()
    {
        $u = new User();
        $u->get_by_id($this->input->post('uid'));
        
        $this->load->library('sendgrid_email');
        $emails = explode(',', $this->input->post('emails'));

        foreach ($emails as $email)
        {
            // generate new share key for each e-mail address
            $ts = new Trip_share();
            $ts->trip_id = $this->input->post('tripId');
            $ts->share_role = $this->input->post('shareRole');
            $ts->share_medium = 1;
            $ts->target_id = $email;
            $share_key = $ts->generate_share_key();

            $response = $this->sendgrid_email->send_mail(
                array($email),
                $u->name.' invited you on a trip on Shoutbound!',
                $this->generate_html_email($u->name, $ts->trip_id, $share_key),
                $this->generate_text_email($u->name, $ts->trip_id, $share_key)
            );
        }

    }
    
    
    function generate_html_email($user_name, $trip_id, $share_key)
    {
        $html = '<h4>'.$user_name.' invited you to a trip on Shoutbound</h4>'.
            '<br/><a href="'.site_url('trips/share/'.$trip_id.'/'.$share_key).'">'.
            'To see the trip, click here.</a>'.
            '<br/>Have fun!<br/>Team Shoutbound';
        
        return $html;
    }
    
    
    function generate_text_email($user_name, $trip_id, $share_key)
    {
        $text = $user_name.' invited you to a trip on Shoutbound'.
            '<br/><a href="'.site_url('trips/share/'.$trip_id.'/'.$share_key).'">'.
            'To see the trip, click here.</a>'.
            '<br/>Have fun!<br/>Team Shoutbound';
            
        return $text;
    }
}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */