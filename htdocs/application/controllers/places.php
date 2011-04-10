<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}


    function ajax_autosuggest()
    {
        $p = new Place();
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
    
    
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */