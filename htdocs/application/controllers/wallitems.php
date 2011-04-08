<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallitems extends CI_Controller
{
    
    public $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        $uid = $u->get_logged_in_status();
        if ($uid)
        {
            $u->get_by_id($uid);
            $this->user = $u->stored;
        }
        else
        {
            redirect('/');
        }
		}


    function index()
    {
        $wi = new Wallitem();
        $wi->get_by_id(1);
        $replies = $wi->get_replies();
        foreach ($replies as $reply)
        {
            print_r($reply);
            echo '<br/><br/>';
        }
        
        
    }
    
}

/* End of file suggestions.php */
/* Location: ./application/controllers/suggestions.php */