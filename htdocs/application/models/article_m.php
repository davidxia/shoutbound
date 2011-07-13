<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_m extends CI_Model
{
    public $id;
    public $author_id;
    public $title;
    public $tagline;
    public $content;
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
            $this->recent_articles[] = new Article_m($article_id);
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
            if ( ! in_array($k, array('id', 'author_id', 'title', 'tagline', 'content', 'created', 'is_active')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file article_m.php */
/* Location: ./application/models/article_m.php */