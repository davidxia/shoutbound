<?php

class Friends extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $u = new User();
        if ( ! $u->get_logged_in_status())
        {
            redirect('/');
        }
    }
    
    
    function edit()
    {
        $uid = get_cookie('uid');       
        $u = new User();
        $u->get_by_id($uid);
        
        $user= $u->stored;

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
            'user' => $user,
            'pending_friends' => $pending_friends,
                           );

        $this->load->view('friends', $view_data);
    }
    
    
    function ajax_add_friend()
    {
        $uid = get_cookie('uid');       
        $u = new User();
        $u->get_by_id($uid);
        
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
        $uid = get_cookie('uid');
        $u = new User();
        $u->get_by_id($uid);

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