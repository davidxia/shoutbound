<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_m extends CI_Model
{
    public $id;
    public $name;
    public $description;
    private $is_private;
    private $is_active;
    

    function __construct($id = NULL)
    {
        parent::__construct();
        if (is_numeric($id))
        {
            $this->get_by_id($id);
        }
    }
    
    public function get_by_id($id)
    {
        $key = 'trip_by_trip_id:'.$id;
        $trip = $this->mc->get($key);
        if ($trip === FALSE)
        {
            $sql = 'SELECT * FROM `trips` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $trip = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $trip);
        }    

        $this->row2obj($trip);
    }


    public function get_creator()
    {
        $key = 'creator_id_by_trip_id:'.$this->id;
        $user_id = $this->mc->get($key);
        
        if ($user_id === FALSE)
        {
            $sql = 'SELECT user_id FROM `trips_users` WHERE trip_id = ? AND role = 10';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $user_id = $rows[0]->user_id;
            $this->mc->set($key, $user_id);
        }
        
        $this->creator = new User_m($user_id);
        return $this;
    }


    public function get_num_goers()
    {
        $key = 'num_goers_by_trip_id:'.$this->id;
        $num_goers = $this->mc->get($key);
        
        if ($num_goers === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `trips_users` WHERE trip_id = ? AND rsvp = 9';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_goers = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_goers);
        }

        $this->num_goers = $num_goers;
        return $this;
    }


    public function get_goers()
    {
        $key = 'goer_ids_by_trip_id:'.$this->id;
        $goer_ids = $this->mc->get($key);
        
        if ($goer_ids === FALSE)
        {
            $goer_ids = array();
            $sql = 'SELECT user_id FROM `trips_users` WHERE trip_id = ? AND rsvp = 9';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $goer_ids[] = $row->user_id;
            }
            $this->mc->set($key, $goer_ids);
        }

        $this->goers = array();
        foreach ($goer_ids as $goer_id)
        {
            $this->goers[] = new User_m($goer_id);
        }
        return $this;
    }
    

    public function get_num_followers()
    {
        $key = 'num_followers_by_trip_id:'.$this->id;
        $num_followers = $this->mc->get($key);
        
        if ($num_followers === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `trips_users` WHERE trip_id = ? AND rsvp = 3';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_followers = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_followers);
        }

        $this->num_followers = $num_followers;
        return $this;
    }


    public function get_followers($user_id = NULL)
    {
        $key = 'follower_ids_by_trip_id:'.$this->id;
        $follower_ids = $this->mc->get($key);
        
        if ($follower_ids === FALSE)
        {
            $follower_ids = array();
            $sql = 'SELECT user_id FROM `trips_users` WHERE trip_id = ? AND rsvp = 3';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $follower_ids[] = $row->user_id;
            }
            $this->mc->set($key, $follower_ids);
        }
        
        $this->followers = array();
        foreach ($follower_ids as $follower_id)
        {
            $follower = new User_m($follower_id);
            if ($user_id)
            {
                $follower->get_follow_status_by_user_id($user_id);
            }
            $this->followers[] = $follower;
        }

        return $this;
    }


    public function get_places()
    {
        $key = 'place_ids_by_trip_id:'.$this->id;
        $place_ids = $this->mc->get($key);
        
        if ($place_ids === FALSE)
        {
            $place_ids = array();
            $sql = 'SELECT place_id FROM `places_trips` WHERE trip_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $place_ids[] = $row->place_id;
            }
            $this->mc->set($key, $place_ids);
        }

        $this->places = array();
        foreach ($place_ids as $place_id)
        {
            $place = new Place_m($place_id);
            $place->get_dates_by_trip_id($this->id);
            $this->places[] = $place;
        }
        return $this;
    }


    public function get_posts()
    {
        $key = 'post_ids_by_trip_id:'.$this->id;
        $post_ids = $this->mc->get($key);

        if ($post_ids === FALSE)
        {
            $post_ids = array();
            $sql = 'SELECT pt.post_id FROM `posts_trips` pt, `posts` p WHERE pt.trip_id = ? AND p.parent_id IS NULL AND pt.is_active = 1 AND pt.post_id = p.id';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $post_ids[] = $row->post_id;
            }
            $this->mc->set($key, $post_ids);
        }

        $this->posts = array();
        foreach ($post_ids as $post_id)
        {
            $post = new Post_m($post_id);
            $post->get_author();
            $post->get_adder_by_trip_id($this->id);
            $post->convert_nl();
            $post->get_places();
            $post->get_trips();
            $post->get_replies();
            $this->posts[] = $post;
        }
        return $this;
    }


    public function get_rsvp_by_user_id($user_id = NULL)
    {
        if ( ! $user_id)
        {
            return FALSE;
        }

        $key = 'rsvp_by_trip_id_user_id:'.$this->id.':'.$user_id;
        $rsvp = $this->mc->get($key);
        
        if ($rsvp === FALSE)
        {
            $sql = 'SELECT rsvp FROM `trips_users` WHERE trip_id = ? AND user_id = ?';
            $v = array($this->id, $user_id);
            $rows = $this->mdb->select($sql, $v);
            $rsvp = (isset($rows[0])) ? $rows[0]->rsvp : 0;
            $this->mc->set($key, $rsvp);
        }
        
        $this->rsvp = $rsvp;
        return $this;
    }


    public function get_role_by_user_id($user_id = NULL)
    {
        if ( ! $user_id)
        {
            return FALSE;
        }

        $key = 'role_by_trip_id_user_id:'.$this->id.':'.$user_id;
        $role = $this->mc->get($key);
        
        if ($role === FALSE)
        {
            $sql = 'SELECT role FROM `trips_users` WHERE trip_id = ? AND user_id = ?';
            $v = array($this->id, $user_id);
            $rows = $this->mdb->select($sql, $v);
            $role = (isset($rows[0])) ? $rows[0]->role : 0;
            $this->mc->set($key, $role);
        }
        
        $this->role = $role;
        return $this;
    }


    // checks if trip is associated with place
    // if so it updates start and enddates
    // if not it adds new row in places_trips table
/*
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
*/


    public function delete($user_id = NULL)
    {
        if ( ! $user_id)
        {
            return FALSE;
        }
        
        // check if trip exists in trips table and is active, ie not deleted
        if ( ! $this->is_active)
        {
            return FALSE;
        }
        
        // check if user is trip's creator
        $this->get_creator();
        if ($this->creator->id != $user_id)
        {
            return FALSE;
        }
        
        $sql = 'UPDATE `trips` SET is_active = ? WHERE id = ?';
        $v = array(0, $this->id);
        $r = $this->mdb->alter($sql, $v);
        if ($r['num_affected'] == 1)
        {            
/*
            $this->get_places();
            foreach ($this->place as $place)
            {
                $this->mc->delete('num_trips_by_place_id:'.$place->id);
                $this->mc->delete('trip_ids_by_place_id:'.$place->id);
                $place->get_related_trips();
                foreach ($place->related_trips as $related_trip)
                {
                    $this->mc->delete('related_trip_ids_by_tripid:'.$related_trip->id);
                }
            }
*/
            return TRUE;
        }
    }
    

    public function delete_post_by_post_id_user_id($post_id = NULL, $user_id = NULL)
    {
        if ( !$post_id OR !$user_id)
        {
            return FALSE;
        }

        $p = new Post_m($post_id);

        // allow removal only if the user is the trip's creator or the post's adder
        $this->get_creator();
        $p->get_adder_by_trip_id($this->id);

        if ($this->creator->id != $user_id AND (!isset($p->added_by) OR $p->added_by->id != $user_id))
        {
            return FALSE;
        }
        
        $num_affected = $p->remove_from_trip_by_trip_id($this->id);
        if ($num_affected == 1)
        {
            $this->mc->delete('post_ids_by_trip_id:'.$this->id);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }



    public function get_related_trips()
    {
        $key = 'related_trip_ids_by_trip_id:'.$this->id;
        $related_trip_ids = $this->mc->get($key);
        
        if ($related_trip_ids === FALSE)
        {
            $related_trip_ids = array();
            $sql = 'SELECT trip_id FROM `places_trips` WHERE place_id IN (SELECT place_id FROM `places_trips` WHERE trip_id = ?) AND trip_id != ?';
            $v = array($this->id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $related_trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $related_trip_ids);
        }

        $this->related_trips = array();
        foreach ($related_trip_ids as $related_trip_id)
        {
            $related_trip = new Trip_m($related_trip_id);
            $related_trip->get_goers();
            $related_trip->get_places();
            $this->related_trips[] = $related_trip;
        }
        return $this;
    }


    private function row2obj($row)
    {
        if ( ! is_null($row))
        {
            foreach (get_object_vars($this) as $k => $v)
            {
                $this->$k = $row->$k;
            }    
        }
        else
        {
            $this->clear();
        }
    }
    

    private function clear()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            $this->$k = NULL;
        }
    }

}

/* End of file trip_m.php */
/* Location: ./application/models/trip_m.php */