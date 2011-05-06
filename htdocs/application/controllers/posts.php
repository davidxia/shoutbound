<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller
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
		
		
		public function index()
		{
		    echo 'a';
		}


		public function ajax_remove_from_trip()
		{
		    $p = new Wallitem($this->input->post('postId'));
		    
		    $r = $p->remove_from_trip($this->input->post('tripId'));
		    
		    if ($r)
		    {
            json_success(array(
                'id' => $p->id,
            ));
		    }
		    else
		    {
		        json_error('something broke, tell David');
		    }
		}
    

}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */