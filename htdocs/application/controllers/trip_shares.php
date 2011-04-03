<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_shares extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function generate_share_key($trip_id, $share_role, $share_medium, $target_id, $is_claimed)
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }

        $ts = new Trip_share();
        $ts->trip_id = $trip_id;
        $ts->share_role = $share_role;
        $ts->share_medium = $share_medium;
        $ts->target_id = $target_id;
        $ts->is_claimed = $is_claimed;

        return $ts->generate_share_key();
    }
    
    
    function ajax_generate_share_key()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
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


    function send_email()
    {
        $u = new User();
        $u->get_by_id($this->input->post('uid'));
        $sender = $u->name;
        
        $this->load->library('sendgrid_email');
        
        if ($this->input->post('uids'))
        {
            $uids = json_decode($this->input->post('uids'));
            
            foreach ($uids as $uid)
            {
                $u->get_by_id($uid);
                $u->settings->get();
                
                if ($u->settings->trip_invite)
                {                
                    // generate new share key for each e-mail
                    $share_key = $this->generate_share_key($this->input->post('tripId'),
                        $this->input->post('shareRole'), 1, $u->email, 0);
                    
                    $response = $this->sendgrid_email->send_mail(
                        array($u->email),
                        $sender.' invited you on a trip on Shoutbound!',
                        $this->generate_html_email($sender, $this->input->post('tripId'), $share_key),
                        $this->generate_text_email($sender, $this->input->post('tripId'), $share_key)
                    );
                }
            }
        }
        elseif ($this->input->post('emails'))
        {
            $emails = $this->input->post('emails');
            $emails = explode(',', $emails);
            
            foreach ($emails as $email)
            {
                // generate new share key for each e-mail
                $share_key = $this->generate_share_key($this->input->post('tripId'),
                    $this->input->post('shareRole'), 1, $email, 0);
                
                $response = $this->sendgrid_email->send_mail(
                    array($email),
                    $sender.' invited you on a trip on Shoutbound!',
                    $this->generate_html_email($sender, $this->input->post('tripId'), $share_key),
                    $this->generate_text_email($sender, $this->input->post('tripId'), $share_key)
                );
                
            }
            
            if ($this->input->post('shareRole') == 2)
            {
                echo 'invites sent';
            }
            elseif ($this->input->post('shareRole') == 1)
            {
                echo 'suggestions asked for';
            }
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
    
    
    function ajax_share_trip()
    {
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ( ! $uid)
        {
            redirect('/');            
        }
        $u->get_by_id($uid);
        
        $trip_id = $this->input->post('tripId');
        
        $t = new Trip();
        $t->get_by_id($trip_id);

        $uids = json_decode($this->input->post('uids'));
                
        foreach ($uids as $uid)
        {
            $u->get_by_id($uid);
            if ($t->save($u))
            {
                $t->set_join_field($u, 'role', $this->input->post('shareRole'));
                $t->set_join_field($u, 'rsvp', 2);
            }
        }
        
        if ($this->input->post('shareRole') == 2)
        {
            echo 'invites sent';
        }
        elseif ($this->input->post('shareRole') == 1)
        {
            echo 'suggestions asked for';
        }
    }
    

    function ajax_trip_share_dialog()
    {
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');            
        }
        $uid = get_cookie('uid');
        $u->get_by_id($uid);
        
        // get Shoutbound friends not related to this trip
        $u->related_user->get();
        // get user ids associated with this trip
        $t = new Trip();
        $t->get_by_id($this->input->post('tripId'));
        $t->user->get();        
        // create array of friends not associated with this trip
        foreach ($t->user as $user)
        {
            $trip_uids[] = $user->id;
        }
        $uninvited_sb_friends = array();
        foreach ($u->related_user as $sb_friend)
        {
            if ( ! in_array($sb_friend->id, $trip_uids))
            {
                $uninvited_sb_friends[] = $sb_friend->stored;
            }
        }
                
        $view_data = array(
            'uninvited_sb_friends' => $uninvited_sb_friends,
            'share_role' => $this->input->post('shareRole')
        );
        
        $render_string = $this->load->view('trip/trip_share_dialog', $view_data, true);
        json_success(array('data' => $render_string));
    }

}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */