<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
            $this->user = $u;
        }
        else
        {
            redirect('/');
        }
		}
	

    function index()
    {
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        $this->user->get_following_trips();
        $this->user->get_num_rsvp_yes_trips();
        $this->user->get_num_posts();
        $this->user->get_num_following();
        $this->user->get_num_following_trips();
        $this->user->get_num_followers();
        
        $t = new Trip();        
        // get suggestions for both user's trips and her friends trips
        $news_feed_items = $this->user->get_news_feed_items();
        
        $view_data = array(
            'user' => $this->user->stored,
            'news_feed_items' => $news_feed_items,
        );
                          
        $this->load->view('home/index', $view_data);
        //print_r($news_feed_items);
    }
        
    
    public function trail()
    {
        $this->user->get_rsvp_yes_trips();
        $this->user->get_rsvp_awaiting_trips();
        
        $data = array(
            'user' => $this->user->stored,
        );
        $this->load->view('home/trail', $data);
    }
    
    
    public function ajax_post_item()
    {
        //$content = $this->input->post('content');

        $t = new Trip();
        $t->where_in('id', $this->input->post('tripIds'))->get();
        
		    $wi = new Wallitem();
		    $wi->user_id = $this->user->id;
		    $wi->content = $this->input->post('content');
		    $wi->parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : NULL;
		    $wi->created = time()-72;
		    
		    if ($wi->save($t->all))
		    {
		        $parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : 0;
		        /*
		        $content = nl2br($this->input->post('content'));
            $content = preg_replace_callback('/<place id="(\d+)">/',
                create_function('$matches',
                    '$p = new Place();
                     $p->get_by_id($matches[1]);
                     return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
                $content);
                
            $content = str_replace('</place>', '</a>', $content);
            */
            json_success(array(
                'id' => $wi->id,
                'userName' => $this->user->name,
                'userId' => $this->user->id,
                'userPic' => $this->user->profile_pic,
                'content' => $this->input->post('content'),
                'parentId' => $parent_id,
                'tripIds' => $this->input->post('tripIds'),
                'created' => time()-72,
            ));
		    }
		    else
		    {
		        json_error('something broke, tell David');
		    }
    }
    
    
    function fb_request_form()
    {
        $this->load->view('fb_request_form');
    }
    
    
    function simplegeo_test()
    {
        $this->load->view('simplegeo_test');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */