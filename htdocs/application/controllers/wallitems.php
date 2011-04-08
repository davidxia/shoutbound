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
        $t = new Trip();
        $t->get_by_id(2);
        $wallitems = array();
        
        $t->wallitem->where('parent_id', NULL)->get();
        foreach ($t->wallitem as $wallitem)
        {
            $wi = new Wallitem();
            $wi->get_by_id($wallitem->id);
            $replies = $wi->get_replies();
            $wallitem->stored->replies = $replies;
            $wallitems[] = $wallitem->stored;
        }
        
        foreach ($wallitems as $wallitem)
        {
            print_r($wallitem);
            echo '<br/><br/>';
        }
        /*
        $wi = new Wallitem();
        $wi->get_by_id(1);
        $replies = $wi->get_replies();
        foreach ($replies as $reply)
        {
            print_r($reply);
            echo '<br/><br/>';
        }
        */
        
    }
    
    function save_place_trip()
    {
        $place_id = 3;
        $p = new Place();
        $p->get_by_id($place_id);

        $t = new Trip();
        $t->get_by_id(2);
        
        if ($p->id)
        {
            $t->save_place_trip($p, time()-72, time()-72);
            echo 'trips place updated';
        }
        else
        {
            echo 'there is no such place';
        }
        
    }
    
    
}

/* End of file suggestions.php */
/* Location: ./application/controllers/suggestions.php */