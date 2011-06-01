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
    
    
    public function ajax_new_share_key()
    {
        $ts = new Trip_share_m();
        $success = $ts->create(array(
            'trip_id' => $this->input->post('tripId'),
            'share_role' => $this->input->post('shareRole'),
            'share_medium' => $this->input->post('shareMedium'),
            'target_id' => $this->input->post('targetId'),
        ));
        

        return $ts->generate_share_key();
    }
    
    
    public function ajax_generate_share_key()
    {
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