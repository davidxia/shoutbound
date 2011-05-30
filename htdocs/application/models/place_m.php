<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place_m extends CI_Model
{
    public $id;
    public $name;
    public $admin1;
    public $country;
    public $type;
    public $lat;
    public $lng;
    public $sw_lat;
    public $sw_lng;
    public $ne_lat;
    public $ne_lng;
    

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
        $key = 'place_by_place_id:'.$id;
        $place = $this->mc->get($key);
        if ($place === FALSE)
        {
            $sql = 'SELECT * FROM `places` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $place = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $place);
        }

        $this->row2obj($place);
    }


    public function get_num_posts()
    {
        $key = 'num_posts_by_place_id:'.$this->id;
        $num_posts = $this->mc->get($key);
        
        if ($num_posts === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `places_posts` WHERE place_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_posts = (int) $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_posts);
        }

        $this->num_posts = $num_posts;
    }


    public function get_posts()
    {
        $key = 'post_ids_by_place_id:'.$this->id;
        $post_ids = $this->mc->get($key);

        if ($post_ids === FALSE)
        {
            $post_ids = array();
            $sql = 'SELECT pp.post_id FROM `places_posts` pp, `posts` p WHERE pp.place_id = ? AND p.parent_id IS NULL AND pp.is_active = 1 AND pp.post_id = p.id';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $post_ids[] = (int) $row->post_id;
            }
            $this->mc->set($key, $post_ids);
        }

        $this->posts = array();
        foreach ($post_ids as $post_id)
        {
            $post = new Post_m($post_id);
            $post->get_author();
            $post->get_added_by();
            $post->convert_nl();
            $post->get_places();
            $post->get_trips();
            $post->get_replies();
            $this->posts[] = $post;
        }
    }


    public function get_num_trips()
    {
        $key = 'num_trips_by_place_id:'.$this->id;
        $num_trips = $this->mc->get($key);
        
        if ($num_trips === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `places_trips` WHERE place_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_trips = (int) $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_trips);
        }

        $this->num_trips = $num_trips;
    }


    public function get_trips()
    {
        $key = 'trip_ids_by_place_id:'.$this->id;
        $trip_ids = $this->mc->get($key);

        if ($trip_ids === FALSE)
        {
            $trip_ids = array();
            $sql = 'SELECT pt.trip_id FROM `places_trips` pt, `trips` t WHERE pt.place_id = ? AND t.is_active = 1 AND pt.trip_id = t.id';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $trip_ids[] = (int) $row->trip_id;
            }
            $this->mc->set($key, $trip_ids);
        }

        $this->trips = array();
        foreach ($trip_ids as $trip_id)
        {
            $trip = new Trip_m($trip_id);
            $trip->get_goers();
            $trip->get_places();
            $this->trips[] = $trip;
        }
    }


    public function get_num_followers()
    {
        $key = 'num_followers_by_place_id:'.$this->id;
        $num_followers = $this->mc->get($key);
        
        if ($num_followers === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `places_users` WHERE place_id = ? AND is_following = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_followers = (int) $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_followers);
        }

        $this->num_followers = $num_followers;
    }


    public function get_followers()
    {
        $key = 'follower_ids_by_place_id:'.$this->id;
        $follower_ids = $this->mc->get($key);

        if ($follower_ids === FALSE)
        {
            $follower_ids = array();
            $sql = 'SELECT pu.user_id FROM `places_users` pu, `users` u WHERE pu.user_id = u.id AND pu.place_id = ? AND pu.is_following = 1 AND u.is_active = 1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $follower_ids[] = (int) $row->user_id;
            }
            $this->mc->set($key, $follower_ids);
        }

        $this->followers = array();
        foreach ($follower_ids as $follower_id)
        {
            $follower = new User_m($follower_id);
            $this->followers[] = $follower;
        }
    }


    public function get_follow_status_by_user_id($user_id)
    {
        $key = 'follow_status_by_place_id_user_id:'.$this->id.':'.$user_id;
        $follow_status = $this->mc->get($key);
        
        if ($follow_status === FALSE)
        {
            $sql = 'SELECT is_following FROM `places_users` WHERE place_id = ? AND user_id = ?';
            $v = array($this->id, $user_id);
            $rows = $this->mdb->select($sql, $v);
            $follow_status = (isset($rows[0])) ? (int) $rows[0]->is_following : 0;
            $this->mc->set($key, $follow_status);
        }

        $this->is_following = $follow_status;
    }
    
    
    public function get_related_places($user_id = NULL)
    {
        $key = 'related_place_ids_by_place_id:'.$this->id;
        $related_place_ids = $this->mc->get($key);
        
        if ($related_place_ids === FALSE)
        {
            $related_place_ids = array();
            $sql = 'SELECT parent_id FROM `places` WHERE id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $related_place_ids[] = (int) $rows[0]->parent_id;

            $sql = 'SELECT pp.related_place_id FROM `places_places` pp WHERE pp.place_id = ?';
            $v = array($this->id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $related_place_ids[] = (int) $row->related_place_id;
            }
            $this->mc->set($key, $related_place_ids);
        }

        $this->related_places = array();
        foreach ($related_place_ids as $related_place_id)
        {
            $related_place = new Place_m($related_place_id);
            if ($user_id)
            {
                $related_place->get_follow_status_by_user_id($user_id);
            }
            $this->related_places[] = $related_place;
        }
    }


    public function get_dates_by_trip_id($trip_id)
    {
        $key = 'dates_by_trip_id_place_id:'.$trip_id.':'.$this->id;
        $this->mc->delete($key);
        $dates = $this->mc->get($key);
        
        if ($dates === FALSE)
        {
            $dates = array();
            $sql = 'SELECT startdate,enddate FROM `places_trips` WHERE trip_id = ? AND place_id = ?';
            $v = array($trip_id, $this->id);
            $rows = $this->mdb->select($sql, $v);
            $dates['startdate'] = (isset($rows[0])) ? (int) $rows[0]->startdate : NULL;
            $dates['enddate'] = (isset($rows[0])) ? (int) $rows[0]->enddate : NULL;
            $this->mc->set($key, $dates);
        }

        $this->dates = $dates;
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

/* End of file place_m.php */
/* Location: ./application/models/place_m.php */