<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_shares extends CI_Controller
{
    
    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        if ($u->get_logged_in_status())
        {
            $this->user = $u;
        }
        else
        {
            custom_404();
            return;
        }
		}
    
    
    public function generate_share_key($trip_id, $share_role, $share_medium, $target_id, $is_claimed)
    {
        $ts = new Trip_share();
        $ts->trip_id = $trip_id;
        $ts->share_role = $share_role;
        $ts->share_medium = $share_medium;
        $ts->target_id = $target_id;
        $ts->is_claimed = $is_claimed;

        return $ts->generate_share_key();
    }
    
    
    public function ajax_generate_share_key()
    {
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
        foreach ($uids as $uid)
        {
            $u->get_by_id($uid);
            $u->settings->where('name', 'trip_invite')->include_join_fields()->get();
            
            if ($u->settings->join_is_on == 1)
            {                
                // generate new share key for each e-mail
                $share_key = $this->generate_share_key($this->input->post('tripId'),
                    $this->input->post('shareRole'), 1, $u->email, 0);
                
                $response = $this->email_notifs->send_mail(
                    array($u->email),
                    $sender.' invited you to a trip on Shoutbound!',
                    $this->generate_html_email($sender, $this->input->post('tripId'), $share_key),
                    $this->generate_text_email($sender, $this->input->post('tripId'), $share_key)
                );
            }
        }
    }
    
    
    private function generate_html_email($user_name, $trip_id, $share_key)
    {
        $html = '<h4>'.$user_name.' invited you to a trip on Shoutbound</h4>'.
            '<br/><a href="'.site_url('trips/share/'.$trip_id.'/'.$share_key).'">'.
            'To see the trip, click here.</a>'.
            '<br/>Have fun!<br/>Team Shoutbound';
        
        return $html;
    }
    
    
    private function generate_text_email($user_name, $trip_id, $share_key)
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