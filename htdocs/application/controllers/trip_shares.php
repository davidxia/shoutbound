<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_shares extends CI_Controller
{
    
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
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
            $data = array('str' => json_success(array('shareKey' => $share_key)));
        }
        else
        {
            $data = array('str' => json_error('something broke, tell David to fix it'));
        }
        
        $this->load->view('blank', $data);
    }


}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */