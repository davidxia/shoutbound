<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suggestions extends CI_Controller
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


    function ajax_save_suggestion()
    {
        $s = new Suggestion();
        
        $s->user_id = $this->user->id;
        $s->trip_id = $this->input->post('tripId');
        $s->name = $this->input->post('name');
        $s->text = $this->input->post('text');
        $s->lat = $this->input->post('lat');
        $s->lng = $this->input->post('lng');
        $s->address = $this->input->post('address');
        $s->phone = $this->input->post('phone');
        $s->created = time()-72;
        
        if ($s->save())
        {
            json_success(array('id'=>$s->id));
        
        }
    }
    
    
    function remove_suggestion()
    {
        $s = new Suggestion();
        $s->where('id', $this->input->post('suggestionId'))->update('active', 0);

        if ($s->db->affected_rows() == 1)
        {
            json_success(array('suggestionId' => $this->input->post('suggestionId')));
        }
    }

    function ajax_like_suggestion()
    {
        $s = new Suggestion();
        $s->where('id', $this->input->post('suggestionId'))->update('votes', 'votes + 1', FALSE);

        if ($s->db->affected_rows() == 1)
        {
            json_success();
        }
        else
        {
            json_error();
        }
    }
}

/* End of file suggestions.php */
/* Location: ./application/controllers/suggestions.php */