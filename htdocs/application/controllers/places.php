<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}


    public function ajax_autocomplete()
    {
        $this->load->library('Mc');

        $query = $this->input->post('query');
        $key = 'places_by_query:'.$query;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $p = new Place();
            $p->ilike('name', $query, 'after')->limit(10)->get();
            
            $val = array();
            foreach ($p as $place)
            {
                $val[$place->id] = $place->name;
            }

            $this->mc->set($key, $val);

            json_success(array(
                'places' => $val,
                'cached' => 0
            ));
        }
        else
        {
            json_success(array(
                'places' => $val,
                'cached' => 1
            ));
        }
    }
    
    public function mytest()
    {
        $this->load->library('Mc');
        
        $key = 'places_by_query:'.'budapest';
        //$val = array('jakarta', 'jabberwokky');
        //print_r($val);
        
        //$this->mc->set($key, $val);
        //$this->mc->delete($key);
        $val = $this->mc->get($key);
        
        print_r($val);
    }
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */