<?php

class Trip_shares extends Controller
{
    
    function Trip_shares()
    {
        parent::Controller();
    }
    
    
    function generate_share_key()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status() OR getenv('REQUEST_METHOD') == 'GET')
        {
            redirect('/');            
        }

        $ts = new Trip_share();
        $ts->trip_id = $this->input->post('tripId');
        $ts->share_role = $this->input->post('shareRole');
        $ts->share_medium = $this->input->post('shareMedium');
        $ts->target_id = $this->input->post('targetId');
        $ts->is_claimed = $this->input->post('isClaimed');

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
    
    
    function send_email_invites()
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
            $ts->share_role = 2;
            $ts->share_medium = 1;
            $ts->target_id = $email;
            $share_key = $ts->generate_share_key();

            $response = $this->sendgrid_email->send_mail(
                array($email),
                $u->name.' invited you on a trip on Shoutbound!',
                '<h4>'.$u->name.
                    ' invited you to a trip on Shoutbound</h4>'.$post['description'].
                    '<br/><a href="'.site_url('trips/share/'.$t->id.'/'.$share_key).
                    '">To see the trip, click here.</a>'.
                    '<br/>Have fun!<br/>Team Shoutbound',
                $u->name.
                    ' invited you to a trip on Shoutbound'.$post['description'].
                    '<br/><a href="'.site_url('trips/share/'.$t->id.'/'.$share_key).
                    '">To see the trip, click here.</a>'.
                    '<br/>Have fun!<br/>Team Shoutbound'
            );
        }

    }
}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */