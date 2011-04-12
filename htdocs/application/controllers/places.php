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
        $p->ilike('name', $this->input->post('query'))->limit(10)->get();
        
        $places = array();
        foreach ($p as $place)
        {
            $places[] = $place->name;
        }

        json_success(array(
            'places' => $places,
        ));
    }
    
    
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */