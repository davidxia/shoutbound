<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Replies extends CI_Controller
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


    function ajax_save_reply()
    {
        $r = new Reply();
        $r->user_id = $this->user->id;
        $r->message_id = $this->input->post('messageId');
        $r->suggestion_id = $this->input->post('suggestionId');
        $r->text = $this->input->post('text');
        $r->created = time()-72;
                
        if ($r->save())
        {
            json_success(array(
                'id' => $r->id,
                'text' => $this->input->post('text'),
                'created' => time()-72,
                'userName' => $this->user->name,
                'uid' => $this->user->id,
            ));
        }
    }
    
    
    function ajax_remove_reply()
    {
        $r = new Reply();
        $r->where('id', $this->input->post('replyId'))->update('active', 0);

        if ($r->db->affected_rows() == 1)
        {
            json_success(array('replyId' => $this->input->post('replyId')));
        }
    }

    
}

/* End of file replies.php */
/* Location: ./application/controllers/replies.php */