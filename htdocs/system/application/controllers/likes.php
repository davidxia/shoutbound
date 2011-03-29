<?php

class Likes extends Controller
{
    
    function Likes()
    {
    	  parent::Controller();
    }


    function ajax_save_like()
    {
        $messageId = $this->input->post('messageId');
        $suggestionId = $this->input->post('suggestionId');
        
        $l = new Like();
        if ($messageId)
        {
            $l->where('message_id', $messageId)->get();
            if ($l->id)
            {
                $l->where('id', $this->input->post('replyId'))->update('active', 0);
            }
        }
        
        
        $l->user_id = $this->input->post('userId');
        $l->message_id = $messageId;
        $l->suggestion_id = $suggestionId;
        $l->like = $this->input->post('like');
        $l->created = time()-72;
                
        if ($l->save())
        {
            $u = new User();
            $u->get_by_id($l->user_id);
            
            json_success(array(
                'id' => $l->id,
                'created' => time()-72,
                'userName' => $u->name,
                'like' => $l->like,
                'uid' => $u->id
            ));
        }
    }    
}

/* End of file likes.php */
/* Location: ./application/controllers/likes.php */