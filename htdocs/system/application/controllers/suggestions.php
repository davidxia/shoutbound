<?php

class Suggestions extends Controller {
    
    function Suggestions()
    {
    	parent::Controller();
    }


    function ajax_save_suggestion()
    {
        $s = new Suggestion();
        
        $s->user_id = $this->input->post('userId');
        $s->trip_id = $this->input->post('tripId');
        $s->name = $this->input->post('name');
        $s->text = $this->input->post('text');
        $s->lat = $this->input->post('lat');
        $s->lng = $this->input->post('lng');
        $s->address = $this->input->post('address');
        $s->phone = $this->input->post('phone');
        
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

    
}