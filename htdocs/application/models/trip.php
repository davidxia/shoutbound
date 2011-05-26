<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip extends DataMapper
{
    private $mc;
 
    public $has_many = array('user', 'place', 'place', 'post', 'suggestion', 'destination', 'trip_share');

    var $validation = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required', 'trim')
        ),
        array(
            'field' => 'response_deadline',
            'label' => 'Deadline',
            'rules' => array('')
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => array('trim')
        ),
    );

    function __construct($id = NULL)
    {
        parent::__construct($id);
        $this->mc = new Mc();
    }
    
    
    public function get_creator()
    {
        $key = 'creator_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->user->where_join_field($this, 'rsvp', 9)->where_join_field($this, 'role', 10)->get();
            $val = $this->user->stored;
            $this->mc->set($key, $val);
        }

        $this->stored->creator = $val;
    }
    
    
    public function get_num_goers()
    {
        $key = 'num_goers_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
             $val = $this->user->where_in_join_field('trip', 'rsvp', 9)->count();
             $this->mc->set($key, $val);
        }

        $this->stored->num_goers = $val;
    }


    public function get_goers()
    {
        $key = 'goers_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->user->where_join_field($this, 'rsvp', 9)->get_iterated() as $goer)
            {
                $val[] = $goer->stored;
            }
            $this->mc->set($key, $val);
        }

        $this->stored->goers = $val;
    }
    
    
    public function get_num_followers()
    {
        $key = 'num_followers_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = $this->user->where_in_join_field('trip', 'rsvp', 3)->count();
            $this->mc->set($key, $val);
        }

        $this->stored->num_followers = $val;
    }
        
    
    public function get_followers($user_id = FALSE)
    {
        $key = 'followers_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->user->where_join_field($this, 'rsvp', 3)->get_iterated() as $follower)
            {
                $val[] = clone $follower->stored;
            }
            $this->mc->set($key, $val);
        }
        
        if ($user_id)
        {
            $u = new User();
            foreach ($val as $k => $v)
            {
                $u->get_by_id($val[$k]->id);
                $u->get_follow_status_by_user_id($user_id);
                $val[$k]->is_following = $u->stored->is_following;
            }
        }

        $this->stored->followers = $val;
    }


    public function get_places()
    {
        $key = 'places_by_trip_id:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->place->include_join_fields()->get_iterated() as $place)
            {
                $place->stored->startdate = $place->join_startdate;
                $place->stored->enddate = $place->join_enddate;
                $val[] = $place->stored;
            }
            $this->mc->set($key, $val);
        }

        $this->stored->places = $val;
    }
        
    
    public function get_posts()
    {
		    $posts = array();
        foreach ($this->post->where('parent_id', NULL)->where_join_field('trip', 'is_active', 1)->order_by('created', 'asc')->get_iterated() as $post)
        {
            // get creator's name
            $post->get_creator();
            $post->get_added_by($this->id);
            // convert \n to <br/>
            $post->convert_nl();
            // generate html for post's places
            $post->get_places();
            // get number of likes
            $post->get_likes();
            $post->get_trips();
            
            // get replies and attach their places
            $post->get_replies();
            $replies = array();
            $r = new Post();
            foreach ($post->stored->replies as $reply)
            {
                $r->get_by_id($reply->id);
                $r->get_creator();
                $r->convert_nl();
                $r->get_places();
                $replies[] = $r->stored;
            }
            
            // packages each post with replies into separate array
            $post->stored->replies = $replies;
            $posts[] = $post->stored;
        }
        
        return $posts;
    }


    // checks if trip is associated with place
    // if so it updates start and enddates
    // if not it adds new row in places_trips table
    public function save_place_trip($place, $startdate=NULL, $enddate=NULL)
    {
        $this->place->where_join_field($this, 'place_id', $place->id)->get();

        if ($this->place->id)
        {
            $this->set_join_field($place, 'startdate', $startdate);
            $this->set_join_field($place, 'enddate', $enddate);
        }
        else
        {
            $place->save($this);
            $this->set_join_field($place, 'startdate', $startdate);
            $this->set_join_field($place, 'enddate', $enddate);
        }
        
        return TRUE;
    }
    
    
    public function delete($user_id = FALSE)
    {
        if (! $user_id)
        {
            return FALSE;
        }
        
        //check if trip exists in trips table and is active, ie not deleted
        if ( ! $this->is_active)
        {
            return FALSE;
        }
        
        //check if user is the creator, redirect to home page otherwise
        $this->user->include_join_fields()->where_join_field($this, 'user_id', $user_id)->get();
        if ($this->user->join_role != 10)
        {
            return FALSE;
        }
        
        $this->where('id', $this->id)->update('is_active', 0);
        $num_affected = $this->db->affected_rows();
        if ($num_affected == 1)
        {
            $this->mc->delete('creator_by_trip_id:'.$this->id);
            foreach ($this->place->get_iterated() as $place)
            {
                $this->mc->delete('num_trips_by_place_id:'.$place->id);
                $this->mc->delete('trips_by_place_id:'.$place->id);
                foreach ($place->trip->get_iterated() as $related_trip)
                {
                    if ($related_trip->id != $this->id)
                    {
                        $this->mc->delete('related_trips_by_tripid:'.$related_trip->id);
                    }
                }
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
        
    
    public function get_rsvp_by_user_id($user_id = NULL)
    {
        if ( ! $user_id)
        {
            return FALSE;
        }

        $key = 'rsvp_by_tripid_userid:'.$this->id.':'.$user_id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->user->where('id', $user_id)->include_join_fields()->get();
            $val = $this->user->join_rsvp;
            $this->mc->set($key, $val);
        }
        
        $this->stored->rsvp = $val;
    }
    
    
    public function get_role_by_user_id($user_id)
    {
        if ( ! $user_id)
        {
            return FALSE;
        }

        $key = 'role_by_tripid_userid:'.$this->id.':'.$user_id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $this->user->where('id', $user_id)->include_join_fields()->get();
            $val = $this->user->join_role;
            $this->mc->set($key, $val);
        }
        
        $this->stored->role = $val;
    }


    public function delete_post($post_id = NULL)
    {
        if ( ! $post_id)
        {
            return FALSE;
        }
        
        $p = new Post($post_id);
        $this->set_join_field($p, 'is_active', 0);
        $this->mc->delete('post_by_trip_id_post_id:'.$this->id.':'.$p->id);
        return TRUE;
    }
    
    
    public function get_related_trips()
    {
        $key = 'related_trips_by_tripid:'.$this->id;
        $val = $this->mc->get($key);
        
        if ($val === FALSE)
        {
            $val = array();
            foreach ($this->place->get_iterated() as $place)
            {
                foreach ($place->trip->where('is_active', 1)->get_iterated() as $trip)
                {
                    if ($trip->id != $this->id)
                    {
                        $val[] = clone $trip->stored;
                    }
                }
            }
            $this->mc->set($key, $val);
        }
        
        $t = new Trip();
        foreach ($val as $k => $v)
        {
            $t->get_by_id($val[$k]->id);
            $t->get_goers();
            $t->get_places();
            $val[$k] = $t->stored;
        }

        $this->stored->related_trips = $val;
    }
    
    
}

/* End of file trip.php */
/* Location: ./application/models/trip.php */