<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_m extends CI_Model
{
    public $id;
    public $author_id;
    public $title;
    public $tagline;
    public $content;
    public $uri_seg;
    public $created;
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
        $key = 'article_by_article_id:'.$id;
        $article = $this->mc->get($key);
        if ($article === FALSE)
        {
            $sql = 'SELECT * FROM `articles` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $article = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $article);
        }
        
        $this->row2obj($article);
        //$this->convert_nl();
        return $this;
    }
    
    
    public function get_by_uri_seg($uri_seg)
    {
        $key = 'article_by_uri_seg:'.$uri_seg;
        $article = $this->mc->get($key);
        if ($article === FALSE)
        {
            $sql = 'SELECT * FROM `articles` WHERE uri_seg=?';
            $v = array($uri_seg);
            $rows = $this->mdb->select($sql, $v);
            $article = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $article);
        }
        
        $this->row2obj($article);
        //$this->convert_nl();
        return $this;
    }
    
    
    public function get_recent_article_ids($n = 5)
    {
        $key = 'recent_article_ids';
        $article_ids = $this->mc->get($key);
        if ($article_ids === FALSE)
        {
            $article_ids = array();
            $sql = 'SELECT `id` FROM `articles` WHERE `is_active` = 1 ORDER BY `created` DESC LIMIT ?';
            $v = array($n);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $article_ids[] = $row->id;
            }
            $this->mc->set($key, $article_ids);
        }
        
        $this->recent_article_ids = $article_ids;
        return $this;
    }
    
    
    public function get_recent_articles($n = 5)
    {
        $this->get_recent_article_ids($n);
        $this->recent_articles = array();
        foreach ($this->recent_article_ids as $article_id)
        {
            $article = new Article_m($article_id);
            $article->get_num_wishers();
            $this->recent_articles[] = $article;
        }
        
        return $this;
    }
    
    
    public function get_prev_article_id()
    {
        $key = 'prev_article_id_by_article_id:'.$this->id;
        $prev_article_id = $this->mc->get($key);
        if ($prev_article_id === FALSE)
        {
            $sql = 'SELECT `id` FROM `articles` WHERE `is_active` = 1 AND `created` < ? LIMIT 1';
            $v = array($this->created);
            $rows = $this->mdb->select($sql, $v);
            $prev_article_id = (isset($rows[0])) ? $rows[0]->id : NULL;
            $this->mc->set($key, $prev_article_id);
        }
        
        $this->prev_article_id = $prev_article_id;
        return $this;
    }
    

    public function get_next_article_id()
    {
        $key = 'next_article_id_by_article_id:'.$this->id;
        $next_article_id = $this->mc->get($key);
        if ($next_article_id === FALSE)
        {
            $sql = 'SELECT `id` FROM `articles` WHERE `is_active` = 1 AND `created` > ? LIMIT 1';
            $v = array($this->created);
            $rows = $this->mdb->select($sql, $v);
            $next_article_id = (isset($rows[0])) ? $rows[0]->id : NULL;
            $this->mc->set($key, $next_article_id);
        }
        
        $this->next_article_id = $next_article_id;
        return $this;
    }


    public function get_prev_article_uri_seg()
    {
        $key = 'prev_article_uri_seg_by_article_id:'.$this->id;
        $prev_article_uri_seg = $this->mc->get($key);
        if ($prev_article_uri_seg === FALSE)
        {
            $sql = 'SELECT `uri_seg` FROM `articles` WHERE `is_active` = 1 AND `created` < ? LIMIT 1';
            $v = array($this->created);
            $rows = $this->mdb->select($sql, $v);
            $prev_article_uri_seg = (isset($rows[0])) ? $rows[0]->uri_seg : NULL;
            $this->mc->set($key, $prev_article_uri_seg);
        }
        
        $this->prev_article_uri_seg = $prev_article_uri_seg;
        return $this;
    }
    

    public function get_next_article_uri_seg()
    {
        $key = 'next_article_uri_seg_by_article_id:'.$this->id;
        $next_article_uri_seg = $this->mc->get($key);
        if ($next_article_uri_seg === FALSE)
        {
            $sql = 'SELECT `uri_seg` FROM `articles` WHERE `is_active` = 1 AND `created` > ? LIMIT 1';
            $v = array($this->created);
            $rows = $this->mdb->select($sql, $v);
            $next_article_uri_seg = (isset($rows[0])) ? $rows[0]->uri_seg : NULL;
            $this->mc->set($key, $next_article_uri_seg);
        }
        
        $this->next_article_uri_seg = $next_article_uri_seg;
        return $this;
    }


    private function convert_nl()
    {
        $this->content = nl2br($this->content);
        return $this;
    }


    public function get_venues()
    {
        $key = 'venue_ids_by_article_id:'.$this->id;
        $venue_ids = $this->mc->get($key);
        if ($venue_ids === FALSE)
        {
            $venue_ids = array();
            $sql = 'SELECT v.id FROM `articles_venues` av, `venues` v WHERE v.id = av.venue_id AND av.is_active = 1 AND v.is_active = 1 AND av.article_id = ?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $venue_ids[] = $row->id;
            }
            $this->mc->set($key, $venue_ids);
        }
        
        $this->venues = array();
        $this->load->model('Venue_m');
        foreach ($venue_ids as $venue_id)
        {
            $venue = new Venue_m($venue_id);
            $venue->get_photos();
            $this->venues[] = $venue;
        }
        return $this;
    }


    public function get_num_wishers()
    {
        $key = 'num_wishers_by_article_id:'.$this->id;
        $num_wishers = $this->mc->get($key);
        if ($num_wishers === FALSE)
        {
            $sql = 'SELECT COUNT(*) FROM `articles_users` au, `users` u WHERE u.id = au.user_id AND u.is_active=1 AND au.article_id=? AND au.is_favorite=1';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            $num_wishers = $rows[0]->{'count(*)'};
            $this->mc->set($key, $num_wishers);
        }
        
        $this->num_wishers = $num_wishers;
        return $this;
    }


    public function get_tags()
    {
        $key = 'tag_ids_by_article_id:'.$this->id;
        $tag_ids = $this->mc->get($key);
        if ($tag_ids === FALSE)
        {
            $tag_ids = array();
            $sql = 'SELECT at.tag_id FROM `articles_tags` at WHERE at.article_id=?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $tag_ids[] = $row->tag_id;
            }
            $this->mc->set($key, $tag_ids);
        }
        
        $this->tags = array();
        $this->load->model('Tag_m');
        foreach ($tag_ids as $tag_id)
        {
            $tag = new Tag_m($tag_id);
            $this->tags[] = $tag;
        }
        return $this;
    }


    public function get_related_articles()
    {
        $key = 'related_article_ids_by_article_id:'.$this->id;
        $related_article_ids = $this->mc->get($key);
        if ($related_article_ids === FALSE)
        {
            $related_article_ids = array();
            $sql = 'SELECT aa.related_article_id FROM `articles_articles` aa WHERE aa.article_id=?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $related_article_ids[] = $row->related_article_id;
            }
            $this->mc->set($key, $related_article_ids);
        }
        
        $this->related_articles = array();
        foreach ($related_article_ids as $article_id)
        {
            $article = new Article_m($article_id);
            $this->related_articles[] = $article;
        }
        return $this;
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
            if ( ! in_array($k, array('id', 'author_id', 'title', 'tagline', 'content', 'uri_seg', 'created', 'is_active')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file article_m.php */
/* Location: ./application/models/article_m.php */