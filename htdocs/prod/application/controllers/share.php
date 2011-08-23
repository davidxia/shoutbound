<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller
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


    public function email_invite($user_id)
    {
        $user = new User_m($user_id);
        $s = $user->increment_invites_clicked();
        redirect('/');
    }
    
}

/* End of file share.php */
/* Location: ./application/controllers/share.php */