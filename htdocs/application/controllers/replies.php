<?php

class Replies extends CI_Controller
{
    
    function __construct()
    {
    	  parent::__construct();
    }


    function ajax_save_reply()
    {
        $r = new Reply();
        $r->user_id = $this->input->post('userId');
        $r->message_id = $this->input->post('messageId');
        $r->suggestion_id = $this->input->post('suggestionId');
        $r->text = $this->input->post('text');
        $r->created = time()-72;
                
        if ($r->save())
        {
            $u = new User();
            $u->get_by_id($r->user_id);
            
            json_success(array(
                'id' => $r->id,
                'text' => $this->input->post('text'),
                'created' => time()-72,
                'userName' => $u->name,
                'uid' => $u->id
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