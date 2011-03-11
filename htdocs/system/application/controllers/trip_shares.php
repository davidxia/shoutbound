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
}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */