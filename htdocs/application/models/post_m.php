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


    public function get_added_by($trip_id = NULL)
    {
        if ( ! $trip_id)
        {
            return FALSE;
        }

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
        
        if ($adder_id)
        {
            $this->added_by = new User_m($adder_id);
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


/*
    public function get_likes()
    {
        $l = new Like();
        $l->where('post_id', $this->id)->get();
        $likes = array();
        foreach ($l as $like)
        {
            $likes[] = $like->stored;
        }
        $this->stored->likes = $likes;
    }
*/


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


    public function remove_from_trip_by_trip_id($trip_id)
    {
        $sql = 'UPDATE `posts_trips` SET is_active = ? WHERE trip_id = ? AND post_id = ?';
        $v = array(0, $trip_id, $this->id);
        $r = $this->mdb->alter($sql, $v);
        return $r['num_affected'];
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

/* End of file post_m.php */
/* Location: ./application/models/post_m.php */