<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallitems extends CI_Controller
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
		
		
		public function ajax_save()
		{
		    $wi = new Wallitem();
		    $wi->trip_id = $this->input->post('tripId');
		    $wi->user_id = $this->user->id;
		    $wi->content = $this->input->post('content');
		    $wi->parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : NULL;
		    $wi->created = time()-72;
		    if ($wi->save())
		    {
		        $parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : 0;
            json_success(array(
                'id' => $wi->id,
                'userName' => $this->user->name,
                'userId' => $this->user->id,
                'userPic' => $this->user->profile_pic,
                'content' => $this->input->post('content'),
                'parentId' => $parent_id,
                'created' => time()-72,
            ));
		    }
		    else
		    {
		        json_error('something broke, tell David');
		    }
		}
		

		public function ajax_remove()
		{
		    $wi = new Wallitem();
		    $wi->get_by_id($this->input->post('id'));
		    $wi->active = 0;
		    if ($wi->save())
		    {
            json_success(array(
                'id' => $wi->id,
            ));
		    }
		    else
		    {
		        json_error('something broke, tell David');
		    }
		}


    public function index()
    {
        $t = new Trip();
        $t->get_by_id(2);
        $wallitems = array();
        
        $t->wallitem->where('parent_id', NULL)->get();
        foreach ($t->wallitem as $wallitem)
        {
            //$wi = new Wallitem();
            //$wi->get_by_id($wallitem->id);
            $replies = $wallitem->get_replies();
            $wallitem->stored->replies = $replies;
            
            $places = $wallitem->get_places();
            $wallitem->stored->places = $places;
            
            $wallitems[] = $wallitem->stored;
        }
        
        foreach ($wallitems as $wallitem)
        {
            print_r($wallitem);
            echo '<br/><br/>';
        }
        /*
        $wi = new Wallitem();
        $wi->get_by_id(1);
        $replies = $wi->get_replies();
        foreach ($replies as $reply)
        {
            print_r($reply);
            echo '<br/><br/>';
        }
        */
        
    }
    
    function save_place_trip()
    {
        $place_id = 3;
        $p = new Place();
        $p->get_by_id($place_id);

        $t = new Trip();
        $t->get_by_id(2);
        
        if ($p->id)
        {
            $t->save_place_trip($p, time()-72, time()-72);
            echo 'trips place updated';
        }
        else
        {
            echo 'there is no such place';
        }
        
    }
    
    
    public function save_place_wallitem()
    {
        $place_id = 3;
        $p = new Place();
        $p->get_by_id($place_id);
        
        $wi = new Wallitem();
        $wi->get_by_id(1);
        
        if ($p->id AND $wi->save($p))
        {
            echo 'place saved to wallitem';
        }
        else
        {
            echo 'not saved';
        }
    }
    
    
    public function ajax_save_like()
    {
        $wallitem_id = $this->input->post('wallitemId');
        $user_id = $this->user->id;
        $is_like = $this->input->post('isLike');
        
        $l = new Like();
        $l->where('wallitem_id', $wallitem_id)->where('user_id', $user_id)->get();
        if ($l->id)
        {
            $l->is_like = $is_like;
            if ($l->save())
            {
                json_success(array(
                    'wallitemId' => $wallitem_id,
                    'isLike' => $is_like,
                    'userId' => $this->user->id,
                    'userName' => $this->user->name,
                ));
            }
        }
        else
        {
            $l->clear();
            $l->wallitem_id = $wallitem_id;
            $l->user_id = $user_id;
            $l->is_like = $is_like;
            $l->created = time()-72;
                    
            if ($l->save())
            {
                json_success(array(
                    'wallitemId' => $wallitem_id,
                    'isLike' => $is_like,
                    'userId' => $this->user->id,
                    'userName' => $this->user->name,
                ));
            }
        }
    }

}

/* End of file suggestions.php */
/* Location: ./application/controllers/suggestions.php */