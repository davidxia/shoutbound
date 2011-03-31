<?php

class Messages extends CI_Controller
{
    
    function __construct()
    {
    	  parent::__construct();
    }


    function ajax_save_message()
    {
        $m = new Message();
        
        $m->user_id = $this->input->post('userId');
        $m->trip_id = $this->input->post('tripId');
        $m->text = $this->input->post('text');
        $m->created = time()-72;
        
        if ($m->save())
        {
            $u = new User();
            $u->get_by_id($m->user_id);
            
            json_success(array(
                'id' => $m->id,
                'text' => $this->input->post('text'),
                'created' => time()-72,
                'uid' => $u->name
            ));
        }
    }
    
    
    function remove_message()
    {
        $m = new Message();
        $m->where('id', $this->input->post('messageId'))->update('active', 0);

        if ($m->db->affected_rows() == 1)
        {
            json_success(array('messageId' => $this->input->post('messageId')));
        }
    }

    
}

/* End of file messages.php */
/* Location: ./application/controllers/messages.php */