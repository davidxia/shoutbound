<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wikiscraper extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		
		
		public function index()
		{
		    $this->load->view('wikiscraper');
		}
    

    public function ajax_dbpedia_query()
    {   
        $query = urlencode($this->input->post('query'));
        
        $query_timeout = 5;
        $handle = popen('/usr/bin/python '.__DIR__.'/../helpers/dbpedia_query.py '.$query, 'r');
        stream_set_blocking($handle, TRUE);
        stream_set_timeout($handle, $query_timeout);
        
        $info = fread($handle, 4096);
        pclose($handle);
        echo $info;
    }
}


/* End of file wikiscraper.php */
/* Location: ./application/controllers/wikiscraper.php */