<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discover extends CI_Controller
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


    public function index()
    {
        $this_user_id = (isset($this->user)) ? $this->user->id : NULL;
        $u = new User_m();
        $user_ids = $u->get_all_user_ids();
        $users = array();        
        
        foreach ($user_ids as $user_id)
        {
            $u->get_by_id($user_id)
              ->get_num_followers()
              ->get_num_posts()
              ->get_num_rsvp_yes_trips()
              ->get_follow_status_by_user_id($this_user_id);
            $u->score = $u->num_followers+$u->num_posts+$u->num_rsvp_yes_trips;
            $users[] = clone $u;

        }
        
        usort($users, function($a, $b) {
            if ($a->score == $b->score)
            {
                return 0 ;
            }
            return ($a->score < $b->score) ? 1 : -1;
        });
        
        $users = array_slice($users, 0, 50);
        
        $data = array(
            'user' => $this->user,
            'users' => $users,
        );
        $this->load->view('discover', $data);
        //echo '<pre>';print_r($users);echo '</pre>';
    }


}

/* End of file discover.php */
/* Location: ./application/controllers/discover.php */