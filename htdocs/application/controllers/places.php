<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Places extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}


    public function ajax_autosuggest()
    {
        //$query = $this->input->post('query');
        $query = 'new';
        
        $this->load->library('Mc');
        
        $key = 'places_by_query:'.$query;
        $val = $this->mc->get($key);
        
        var_dump($key);
        echo '<br/><br/>';
        
        if ($val === false)
        {
            $p = new Place();
            $p->ilike('name', $query, 'after')->limit(10)->get();
            
            $val = array();
            foreach ($p as $place)
            {
                $val[] = $place->name;
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
        
        $key = 'places_by_query:'.'jak';
        $val = array('jakarta', 'jabberwokky');
        print_r($val);
        
        $this->mc->set($key, $val);
        $val = $this->mc->get($key);
        
        print_r($val);
        
            
    }
}

/* End of file places.php */
/* Location: ./application/controllers/places.php */