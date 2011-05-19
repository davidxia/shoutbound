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
            $this->user = $u;
        }
        else
        {
            redirect('/');
        }
		}
		
		public function ajax_save()
		{
		    $content = $this->input->post('content');
		    $parent_id = $this->input->post('parentId');
		    $trip_ids = $this->input->post('tripIds');
		    $is_repost = ($this->input->post('isRepost')) ? $this->input->post('isRepost') : FALSE;
        $t = new Trip();
        $t->where_in('id', $trip_ids)->get();
        
        if ($this->input->post('postId'))
        {
            $p = new Post($this->input->post('postId'));
        }
        else
        {
    		    $p = new Post();
    		    $p->user_id = $this->user->id;
    		    $p->content = $content;
    		    $p->parent_id = ($parent_id) ? $parent_id : NULL;
    		    $p->created = time()-72;        
        }
		    
		    if ($p->save($t->all))
		    {
		        $parent_id = ($parent_id) ? $parent_id : 0;
		        if ($is_repost)
		        {
		            $p->set_join_field($t, 'added_by', $this->user->id);
		        }
		        
            $content = nl2br($content);
            $content = preg_replace_callback('/<place id="(\d+)">/',
                create_function('$matches',
                    '$p = new Place();
                     $p->get_by_id($matches[1]);
                     return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
                $content);
            $content = str_replace('</place>', '</a>', $content);
            
            $activity_type = ($parent_id) ? 6 : 2;
            if ($parent_id)
            {
                $pid = $parent_id;
            }
            elseif (isset($trip_ids[0]))
            {
                $pid = $trip_ids[0];
            }
            else
            {
                $pid = NULL;
            }
            $parent_type = ($parent_id) ? 4 : 2;
            $this->load->helper('activity');
            save_activity($this->user->id, $activity_type, $p->id, $pid, $parent_type, time()-72);
            
            $this->load->library('email_notifs', array('setting_id' => 11, 'user' => $this->user));
            foreach ($t as $trip)
            {
                $this->email_notifs->set_params(array('trip' => $trip));
                $this->email_notifs->clear_emails();
                $this->email_notifs->get_emails();
                $this->email_notifs->compose_email($this->user->stored, $p->stored, $trip->stored);
                $this->email_notifs->send_email();
            }
            $this->email_notifs->set_params(2);
            $this->email_notifs->clear_emails();
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user->stored, $p->stored, $t);
            $this->email_notifs->send_email();
            
            json_success(array(
                'id' => $p->id,
                'userName' => $this->user->name,
                'userId' => $this->user->id,
                'userPic' => $this->user->profile_pic,
                'content' => $content,
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
		
    
    public function ajax_save_like()
    {
        $post_id = $this->input->post('postId');
        $user_id = $this->user->id;
        $is_like = $this->input->post('isLike');
        
        $l = new Like();
        $l->where('post_id', $post_id)->where('user_id', $user_id)->get();
        if ($l->id)
        {
            $l->is_like = $is_like;
            if ($l->save())
            {
                json_success(array(
                    'postId' => $post_id,
                    'isLike' => $is_like,
                    'userId' => $this->user->id,
                    'userName' => $this->user->name,
                ));
            }
        }
        else
        {
            $l->clear();
            $l->post_id = $post_id;
            $l->user_id = $user_id;
            $l->is_like = $is_like;
            $l->created = time()-72;
                    
            if ($l->save())
            {
                json_success(array(
                    'postId' => $post_id,
                    'isLike' => $is_like,
                    'userId' => $this->user->id,
                    'userName' => $this->user->name,
                ));
            }
        }
    }
    

    public function ajax_add_to_trip()
    {
        $t = new Trip();
        $t->where_in('id', $this->input->post('tripIds'))->get();
        
        if ($this->input->post('postId'))
        {
            $p = new Post($this->input->post('postId'));
        }
        else
        {
    		    $p = new Post();
    		    $p->user_id = $this->user->id;
    		    $p->content = $this->input->post('content');
    		    $p->parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : NULL;
    		    $p->created = time()-72;        
        }
		    
		    if ($p->save($t->all))
		    {
		        $parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : 0;
		        $p->set_join_field($t, 'added_by', $this->user->id);
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
                'id' => $p->id,
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
}

/* End of file posts.php */
/* Location: ./application/controllers/posts.php */