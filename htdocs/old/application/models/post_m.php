<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_m extends CI_Model
{
    public $id;
    public $user_id;
    public $content;
    public $parent_id;
    public $created;
    

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
        $key = 'post_by_post_id:'.$id;
        $post = $this->mc->get($key);
        if ($post === FALSE)
        {
            $sql = 'SELECT * FROM `posts` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $post = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $post);
        }
        
        $this->row2obj($post);
        return $this;
    }


    public function get_author()
    {
        $key = 'author_id_by_trip_id:'.$this->id;
        $author_id = $this->mc->get($key);
        
        if ($author_id === FALSE)
        {
            $sql = 'SELECT user_id FROM `posts` WHERE id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $author_id = $rows[0]->user_id;
            $this->mc->set($key, $author_id);
        }
        
        $this->author = new User_m($author_id);
        return $this;
    }


    public function get_adder_by_trip_id($trip_id = NULL)
    {
        $key = 'adder_id_by_post_id_trip_id:'.$this->id.':'.$trip_id;
        $adder_id = $this->mc->get($key);
        
        if ($adder_id === FALSE)
        {
            $sql = 'SELECT added_by FROM `posts_trips` WHERE post_id = ? AND trip_id = ?';
            $v = array($this->id, $trip_id);
            $rows = $this->mdb->select($sql, $v);
            $adder_id = (isset($rows[0])) ? $rows[0]->added_by : NULL;
            $this->mc->set($key, $adder_id);
        }
        
        $this->added_by = new User_m($adder_id);
        return $this;
    }


    public function get_poster_by_place_id($place_id = NULL)
    {
        $key = 'poster_id_by_post_id_place_id:'.$this->id.':'.$place_id;
        $poster_id = $this->mc->get($key);
        
        if ($poster_id === FALSE)
        {
            $sql = 'SELECT `posted_by` FROM `places_posts` WHERE `post_id` = ? AND `place_id` = ?';
            $v = array($this->id, $place_id);
            $rows = $this->mdb->select($sql, $v);
            $poster_id = (isset($rows[0])) ? $rows[0]->posted_by : NULL;
            $this->mc->set($key, $poster_id);
        }
        
        if ($poster_id)
        {
            $this->posted_by = new User_m($poster_id);
        }
        return $this;
    }


    public function convert_nl()
    {
        $this->content = nl2br($this->content);
        return $this;
    }


    public function get_places()
    {
/*
        $key = 'content_by_post_id:'.$this->id;
        $content = $this->mc->get($key);
        
        if ($content === FALSE)
        {
            $content = preg_replace_callback('/<place id="(\d+)">/',
                create_function('$matches',
                    '$p = new Place_m($matches[1]);
                     return \'<a class="place" href="#" address="\'.$p->name.\'" lat="\'.$p->lat.\'" lng="\'.$p->lng.\'">\';'),
                $this->content);
            $content = str_replace('</place>', '</a>', $content);
            $this->mc->set($key, $content);
        }
        
        $this->content = $content;
        return $this;
*/

        $key = 'place_ids_by_post_id:'.$this->id;
        $place_ids = $this->mc->get($key);
        
        if ($place_ids === FALSE)
        {
            preg_match_all('/<place id="(\d+)">/', $this->content, $place_ids);
            $place_ids = $place_ids[1];
            $this->mc->set($key, $place_ids);
        }
        
        $places = array();
        foreach ($place_ids as $place_id)
        {
            $place = new Place_m();
            $place->get_by_id($place_id);
            $places[] = $place;
        }
        
        $this->places = $places;
        return $this;
    }


    public function get_replies()
    {
        $key = 'reply_ids_by_post_id:'.$this->id;
        $reply_ids = $this->mc->get($key);
        
        if ($reply_ids === FALSE)
        {
            $reply_ids = array();
            $sql = 'SELECT id FROM `posts` WHERE parent_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $reply_ids[] = $row->id;
            }
            $this->mc->set($key, $reply_ids);
        }

        $this->replies = array();
        foreach ($reply_ids as $reply_id)
        {
            $reply = new Post_m($reply_id);
            $reply->get_author();
            $reply->convert_nl();
            $reply->get_places();
            $this->replies[] = $reply;
        }
        return $this;
    }


    public function get_trips()
    {
        $key = 'trip_ids_by_post_id:'.$this->id;
        $trip_ids = $this->mc->get($key);
        
        if ($trip_ids === FALSE)
        {
            $trip_ids = array();
            $sql = 'SELECT trip_id FROM `posts_trips` WHERE post_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $trip_ids[] = $row->trip_id;
            }
            $this->mc->set($key, $trip_ids);
        }

        $this->trips = array();
        foreach ($trip_ids as $trip_id)
        {
            $trip = new Trip_m($trip_id);
            $trip->get_places();
            $this->trips[] = $trip;
        }
        return $this;
    }    
    

    public function remove_by_trip_id_user_id($trip_id = NULL, $user_id = NULL)
    {
        if ( !$trip_id OR !$user_id)
        {
            return FALSE;
        }

        // allow removal only if the user is the trip's creator or the post's adder
        $trip = new Trip_m($trip_id);
        $trip->get_creator();
        $this->get_adder_by_trip_id($trip_id);

        if ($trip->creator->id != $user_id AND (!isset($this->added_by) OR $this->added_by->id != $user_id))
        {
            return FALSE;
        }
        
        $sql = 'UPDATE `posts_trips` SET `is_active` = ? WHERE `trip_id` = ? AND `post_id` = ?';
        $v = array(0, $trip_id, $this->id);
        $r = $this->mdb->alter($sql, $v);

        if ($r['num_affected'] == 1)
        {
            $this->mc->delete('post_ids_by_trip_id:'.$trip_id);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    public function get_likes($user_id = NULL)
    {
        $key = 'like_ids_by_post_id:'.$this->id;
        $like_ids = $this->mc->get($key);
        
        if ($like_ids === FALSE)
        {
            $like_ids = array();
            $sql = 'SELECT id FROM `likes` WHERE post_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $like_ids[] = $row->id;
            }
            $this->mc->set($key, $like_ids);
        }

        $this->likes = array();
        $this->load->model('Like_m');
        $like = new Like_m();
        foreach ($like_ids as $like_id)
        {
            $like->get_by_id($like_id);
            $this->likes[$like->user_id] = $like->is_like;
        }
        return $this;
    }
    
    
    public function create($params)
    {
        if ( ! is_array($params))
        {
           return FALSE;
        }
        
        $user_id = (isset($params['user_id'])) ? $params['user_id'] : NULL;
        $content = (isset($params['content'])) ? $params['content'] : NULL;
        $parent_id = (isset($params['parent_id'])) ? $params['parent_id'] : NULL;
        $created = time() - 72;
        
        if (!isset($user_id) OR !isset($content))
        {
            return FALSE;
        }
                
        $sql = 'INSERT INTO `posts` (`user_id`, `content`, `parent_id`, `created`) VALUES (?, ?, ?, ?)';
        $values = array($user_id, $content, $parent_id, $created);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->mc->delete('post_ids_by_user_id:'.$user_id);
            $this->mc->delete('num_posts_by_user_id:'.$user_id);
            $this->id = $r['last_insert_id'];
            $this->user_id = $user_id;
            $this->content = $content;
            $this->parent_id = $parent_id;
            if ($parent_id)
            {
                $this->mc->delete('reply_ids_by_post_id:'.$parent_id);
            }
            
            preg_match_all('/<place id="(\d+)">/', $content, $place_ids);
            $place_ids = $place_ids[1];
    		    if ($place_ids)
    		    {
    		        $this->save_to_places_by_place_ids($place_ids);
    		    }
            return TRUE;
        }
    }
    
    
    public function save_to_trips_by_trip_ids($trip_ids = array(), $added_by = NULL)
    {
        $sql = 'INSERT INTO `posts_trips` (`trip_id`, `post_id`, `added_by`, `created`) VALUES (?,?,?,?)';
        $values = array();
        $created = time()-72;
        foreach ($trip_ids as $trip_id)
        {
            $values[] = array($trip_id, $this->id, $added_by, $created);
        }
        $r = $this->mdb->batch_alter($sql, $values);
        if ($r['num_affected'] > 0)
        {
            return $r['num_affected'];
        }
        else
        {
            return FALSE;
        }
    }


    public function save_to_places_by_place_ids($place_ids = array(), $posted_by = NULL)
    {
        if ( ! $place_ids)
        {
            return -1;
        }
        
        $sql = 'INSERT INTO `places_posts` (`place_id`, `post_id`, `posted_by`) VALUES (?,?,?)';
        $values = array();
        foreach ($place_ids as $place_id)
        {
            $values[] = array($place_id, $this->id, $posted_by);
        }
        $r = $this->mdb->batch_alter($sql, $values);
        if ($r['num_affected'] > 0)
        {
            foreach ($place_ids as $place_id)
            {
                $this->mc->delete('post_ids_by_place_id:'.$place_id);
                $this->mc->delete('num_posts_by_place_id:'.$place_id);
            }
            return $r['num_affected'];
        }
        else
        {
            return FALSE;
        }
    }


    private function row2obj($row)
    {
        if ( ! is_null($row))
        {
            $this->reset_properties();
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
    
    
    private function reset_properties()
    {
        foreach (get_object_vars($this) as $k => $v)
        {
            if ( ! in_array($k, array('id', 'user_id', 'content', 'parent_id', 'created')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file post_m.php */
/* Location: ./application/models/post_m.php */