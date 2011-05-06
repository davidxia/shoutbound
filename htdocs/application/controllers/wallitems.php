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
		    $trip_id = $this->input->post('tripId');
		    $parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : NULL;
		    $content = $this->input->post('content');
		    
		    $wi = new Wallitem();
		    $wi->user_id = $this->user->id;
		    $wi->content = $content;
		    $wi->parent_id = $parent_id;
		    $wi->created = time()-72;

		    if ($trip_id)
		    {
		        $t = new Trip($trip_id);
		        $wi->save($t);
		    }
		    else
		    {
		        $wi->save();
		    }
		    
        $content = nl2br($content);
        $content = preg_replace_callback('/<place id="(\d+)">/',
            create_function('$matches',
                '$p = new Place();
                 $p->get_by_id($matches[1]);
                 return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
            $content);
            
        $content = str_replace('</place>', '</a>', $content);
        
        $a = new Activitie();
        $a->user_id = $this->user->id;
        $a->activity_type = ($parent_id) ? 6 : 2;
        $a->source_id = $wi->id;
        $a->parent_id = ($parent_id) ? $parent_id : $trip_id;
        $a->parent_type = ($parent_id) ? 4 : 2;
        $a->timestamp = time()-72;
        $a->save();

        json_success(array(
            'id' => $wi->id,
            'userName' => $this->user->name,
            'userId' => $this->user->id,
            'userPic' => $this->user->profile_pic,
            'content' => $content,
            'parentId' => $parent_id,
            'created' => time()-72,
        ));
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
