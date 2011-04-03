<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
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


    function ajax_save_message()
    {
        $m = new Message();
        $m->user_id = $this->user->id;
        $m->trip_id = $this->input->post('tripId');
        $m->text = $this->input->post('text');
        $m->created = time()-72;
        
        if ($m->save())
        {
            json_success(array(
                'id' => $m->id,
                'text' => $this->input->post('text'),
                'created' => time()-72,
                'uid' => $this->user->name,
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