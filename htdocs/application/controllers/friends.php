<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller
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
            custom_404();
            return;
        }
    }
    
    
    function edit()
    {
        $u = new User();
        $u->get_by_id($this->user->id);

        // get pending friend requests
        // get array of friends relations to the user
        $u->user->get();
        $rels_to = array();
        foreach ($u->user as $rel_to)
        {
            $rels_to[] = $rel_to->id;
        }
        // compare with array of friend relations from the user
        // TODO: is there a better way of doing this? like with a 'where' clause in one datamapper call?
        $u->related_user->get();
        $rels_from = array();
        foreach ($u->related_user as $rel_from)
        {
            $rels_from[] = $rel_from->id;
        }
        $pending_friends_ids = array_diff($rels_to, $rels_from);
        
        $pending_friends = array();
        foreach ($pending_friends_ids as $uid)
        {
            $u->get_by_id($uid);
            $pending_friends[] = $u->stored;
        }

        $view_data = array(
            'user' => $this->user,
            'pending_friends' => $pending_friends,
        );

        $this->load->view('friends', $view_data);
    }
    
    
    function ajax_add_friend()
    {
        $u = new User();
        $u->get_by_id($this->user->id);
        
        $fid = $this->input->post('friendId');
        $f = new User();
        $f->get_by_id($fid);
        
        if ($f->save($u))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    
    
    function ajax_accept_request()
    {
        $u = new User();
        $u->get_by_id($this->user->id);

        $fid = $this->input->post('friendId');
        $f = new User();
        $f->get_by_id($fid);

        if ($f->save($u))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }

}

/* End of file friends.php */
/* Location: ./application/controllers/friends.php */