<?php

class Trip_shares extends Controller
{
    
    function Trip_shares()
    {
        parent::Controller();
    }
    
    
    function generate_share_key()
    {
        $ts = new Trip_share();
        $ts->trip_id = $this->input->post('tripId');
        
        $salt = rand(1000000,99999999);
        $ts->share_key = md5($this->input->post('tripId').$salt.$this->input->post('targetId'));
        $ts->share_role = $this->input->post('shareRole');
        $ts->share_medium = $this->input->post('shareMedium');
        $ts->target_id = $this->input->post('targetId');
        
        if ($ts->save())
        {
            json_success(array('shareKey' => $ts->share_key));
        }
    }

}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */