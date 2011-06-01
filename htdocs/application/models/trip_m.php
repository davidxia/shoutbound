<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_m extends CI_Model
{
    public $id;
    public $name;
    public $description;
    public $response_deadline;
    public $is_private;
    public $is_active;
    

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


    public function create($params = array())
    {
        $name = (isset($params['name'])) ? $params['name'] : NULL;
        $user_id = (isset($params['user_id'])) ? $params['user_id'] : NULL;
        $description = (isset($params['description'])) ? $params['description'] : NULL;
        $response_deadline = (isset($params['response_deadline'])) ? $params['response_deadline'] : NULL;
        $is_private = (isset($params['is_private'])) ? $params['is_private'] : 0;
        $places_dates = (isset($params['places_dates'])) ? $params['places_dates'] : NULL;
        $created = time() - 72;
        $updated = $created;
        
        if ( !isset($name) OR !isset($user_id) OR !isset($places_dates))
        {
            return FALSE;
        }
        
        $sql = 'INSERT INTO `trips` (`name`, `description`, `response_deadline`, `is_private`, `created`, `updated`) VALUES (?,?,?,?,?,?)';
        $values = array($name, $description, $response_deadline, $is_private, $created, $updated);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $trip_id = $r['last_insert_id'];
            $sql = 'INSERT INTO `trips_users` (`user_id`, `trip_id`, `rsvp`, `role`) VALUES (?,?,?,?)';
            $values = array($user_id, $trip_id, 9, 10);
            $r = $this->mdb->alter($sql, $values);
            if ($r['num_affected'] == 1)
            {
                $error = FALSE;
                foreach ($places_dates as $k => $v)
                {
                    $sql = 'INSERT INTO `places_trips` (`trip_id`, `place_id`, `startdate`, `enddate`) VALUES (?,?,?,?)';
                    $values = array($trip_id, $k, $v['startdate'], $v['enddate']);
                    $r = $this->mdb->alter($sql, $values);
                    if ($r['num_affected'] != 1)
                    {
                        $error = TRUE;
                    }
                }
                if ( ! $error)
                {
                    $this->mc->delete('num_rsvp_yes_trips_by_user_id:'.$user_id);
                    $this->mc->delete('rsvp_yes_trip_ids_by_user_id:'.$user_id);
                    $this->id = $trip_id;
                    $this->name = $name;
                    $this->description = $description;
                    $this->response_deadline = $response_deadline;
                    $this->is_private = $is_private;
                    $this->is_active = 1;
                    return TRUE;                
                }
            }
        }
        return FALSE;
    }


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
            $this->get_goers()->get_followers()->get_places();

            $this->mc->delete('trip_by_trip_id:'.$this->id);
            $this->mc->delete('trip_ids_by_user_id:'.$user_id);
            
            foreach ($this->goers as $goer)
            {
                $this->mc->delete('num_rsvp_yes_trips_by_user_id:'.$goer->id);
                $this->mc->delete('rsvp_yes_trip_ids_by_user_id:'.$goer->id);
            }
            foreach ($this->follower as $follower)
            {
                $this->mc->delete('num_following_trips_by_user_id:'.$follower->id);
                $this->mc->delete('following_trip_ids_by_user_id:'.$follower->id);                
            }
            foreach ($this->place as $place)
            {
                $this->mc->delete('num_trips_by_place_id:'.$place->id);
                $this->mc->delete('trip_ids_by_place_id:'.$place->id);
                $place->get_related_trips();
                foreach ($place->related_trips as $related_trip)
                {
                    $this->mc->delete('related_trip_ids_by_trip_id:'.$related_trip->id);
                }
            }
            return TRUE;
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