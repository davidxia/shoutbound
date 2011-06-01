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
        

        $data = array('str' => $ts->share_key);
        $this->load->view('blank', $data);
    }
}

/* End of file trip_shares.php */
/* Location: ./application/controllers/trip_shares.php */