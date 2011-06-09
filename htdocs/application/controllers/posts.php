<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller
{
    private $user;
    
    function __construct()
    {
        parent::__construct();
        $u = new User_m();
        $u->get_logged_in_user();
        if ($u->id)
        {
            $this->user = $u;
        }
		}
		
				
		public function ajax_save()
		{
		    $post_id = ($this->input->post('postId')) ? $this->input->post('postId') : NULL;
		    $content = ($this->input->post('content')) ? $this->input->post('content') : NULL;
		    $parent_id = ($this->input->post('parentId')) ? $this->input->post('parentId') : NULL;
		    $trip_ids = ($this->input->post('tripIds')) ? $this->input->post('tripIds') : array();
		    $place_id = ($this->input->post('placeId')) ? $this->input->post('placeId') : NULL;
		    $added_by = ($post_id) ? $this->user->id : NULL;
		    
		    if ( ! $content)
		    {
		        return FALSE;
		    }
		            
        $post = new Post_m();
        if ($post_id)
        {
            $post->get_by_id($post_id);
        }
        else
        {
    		    $success = $post->create(array(
    		        'user_id' => $this->user->id,
    		        'content' => $content,
    		        'parent_id' => $parent_id
    		    ));
    		    if ( ! $success)
    		    {
    		        return FALSE;
    		    }
        }
        
        if ($place_id)
        {
            $post->save_to_places_by_place_ids(array($place_id));
            $data = array(
                'post' => $post,
                'user' => $this->user,
            );
            $this->load->view('templates/new_post', $data);
            return;
        }
        elseif ( ! $trip_ids)
        {
            $data = array(
                'post' => $post,
                'user' => $this->user,
                'trip_ids' => array(),
            );
            // if post is reply, notify author of parent post
            if ($parent_id)
            {
                $parent_post = new Post_m($parent_id);
                $this->load->library('email_notifs', array('setting_id' => 6, 'post' => $parent_post));
                $this->email_notifs->get_emails();
                $this->email_notifs->compose_email($this->user, $post, $parent_post);
                $this->email_notifs->send_email();
            }
            $this->load->view('templates/new_comment', $data);
        }
        elseif ($post->save_to_trips_by_trip_ids($trip_ids, $added_by))
        {
            foreach ($trip_ids as $trip_id)
            {
                $this->mc->replace('adder_id_by_post_id_trip_id:'.$post->id.':'.$trip_id, $this->user->id);
                $this->mc->delete('post_ids_by_trip_id:'.$trip_id);
            }

/*
            $content = nl2br($content);
            $content = preg_replace_callback('/<place id="(\d+)">/',
                create_function('$matches',
                    '$p = new Place_m();
                     $p->get_by_id($matches[1]);
                     return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
                $content);
            $content = str_replace('</place>', '</a>', $content);
*/

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
            $this->load->model('Activity_m');
            $activity = new Activity_m();
            $activity->create(array(
                'user_id' => $this->user->id,
                'activity_type' => $activity_type,
                'source_id' => $post->id,
                'parent_id' => $pid,
                'parent_type' => $parent_type,
            ));
            
            $this->load->library('email_notifs', array('setting_id' => 11, 'user' => $this->user));
            $trip = new Trip_m();
            $trips = array();
            foreach ($trip_ids as $trip_id)
            {
                $trip->get_by_id($trip_id);
                $trips[] = $trip;
                $r = $this->email_notifs->set_params(array('trip' => $trip));
                $this->email_notifs->clear_emails();
                $this->email_notifs->get_emails();
                $this->email_notifs->compose_email($this->user, $post, $trip);
                $this->email_notifs->send_email();
            }
            $this->email_notifs->set_params(2);
            $this->email_notifs->clear_emails();
            $this->email_notifs->get_emails();
            $this->email_notifs->compose_email($this->user, $post, $trips);
            $this->email_notifs->send_email();

            $data = array(
                'post' => $post,
                'user' => $this->user,
                'trip_ids' => $trip_ids,
            );
            $this->load->view('templates/new_post', $data);
		    }
		    else
		    {
		        json_error();
		    }
		    
		}
    
    
    public function ajax_set_like()
    {
        $post_id = $this->input->post('postId');
        $user_id = $this->user->id;
        $is_like = $this->input->post('isLike');
        
        if ($this->user->set_like_for_post_id($post_id, $is_like))
        {
            $data = array('str' => json_success(array(
                'postId' => $post_id,
                'isLike' => $is_like,
                'userId' => $this->user->id,
                'userName' => $this->user->name,
            )));
        }
        else
        {
            $data = array('str' => json_error());
        }
        
        $this->load->view('blank', $data);
        
    }
}

/* End of file posts.php */
/* Location: ./application/controllers/posts.php */