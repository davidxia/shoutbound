<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wikiscraper extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
		}
		
		
		function index()
		{
		    $this->load->view('wikiscraper');
		}
    

    function ajax_dbpedia_query()
    {   
        $query = urlencode($this->input->post('query'));
        
        $query_timeout = 99;
        $handle = popen('/usr/bin/python /home/david/wikiscraper/dbpedia_test.py '.$query, 'r');
        stream_set_blocking($handle, TRUE);
        stream_set_timeout($handle, $query_timeout);
        
        $info = fread($handle, 9999999);
        pclose($handle);
        echo $info;
    }    

}


/* End of file wikiscraper.php */
/* Location: ./application/controllers/wikiscraper.php */