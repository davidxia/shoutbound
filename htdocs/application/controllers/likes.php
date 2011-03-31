<?php

class Likes extends CI_Controller
{
    
    function __construct()
    {
    	  parent::__construct();
    }


    function ajax_save_like()
    {
        $user_id = $this->input->post('userId');
        $message_id = $this->input->post('messageId');
        $suggestion_id = $this->input->post('suggestionId');
        $is_like = $this->input->post('isLike');
        
        $message_id ? $type='message_id' : $type='suggestion_id';
        $message_id ? $type_id=$message_id : $type_id=$suggestion_id;
        
        $l = new Like();
        //if ($suggestionId)
        //{
            $l->where($type, $type_id)->where('user_id', $user_id)->update('is_like', $is_like);
            if ($l->db->affected_rows() == 1)
            {
                $u = new User();
                $u->get_by_id($user_id);
                
                json_success(array(
                    //'id' => $l->id,
                    'userName' => $u->name,
                    'isLike' => $is_like,
                    'uid' => $user_id
                ));
            }
            elseif ($l->db->affected_rows() == 0)
            {
                $l->clear();
                $l->user_id = $user_id;
                if ($type == 'message_id')
                {
                    $l->message_id = $type_id;
                }
                elseif ($type == 'suggestion_id')
                {
                    $l->suggestion_id = $type_id;
                }
                $l->is_like = $is_like;
                $l->created = time()-72;
                        
                if ($l->save())
                {
                    $u = new User();
                    $u->get_by_id($user_id);
                    
                    json_success(array(
                        //'id' => $l->id,
                        'userName' => $u->name,
                        'isLike' => $is_like,
                        'uid' => $user_id
                    ));
                }
            }
        //}
        
        
    }    
}

/* End of file likes.php */
/* Location: ./application/controllers/likes.php */