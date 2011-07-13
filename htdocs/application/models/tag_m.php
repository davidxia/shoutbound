<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_m extends CI_Model
{
    public $id;
    public $uri_seg;
    public $name;
    
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
        $key = 'tag_by_tag_id:'.$id;
        $tag = $this->mc->get($key);
        if ($tag === FALSE)
        {
            $sql = 'SELECT * FROM `tags` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $tag = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $tag);
        }
        
        $this->row2obj($tag);
        return $this;
    }
        

    public function get_by_uri_seg($uri_seg)
    {
        $key = 'tag_by_tag_name:'.$uri_seg;
        $tag = $this->mc->get($key);
        if ($tag === FALSE)
        {
            $sql = 'SELECT * FROM `tags` WHERE uri_seg=?';
            $v = array($uri_seg);
            $rows = $this->mdb->select($sql, $v);
            $tag = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $tag);
        }
        
        $this->row2obj($tag);
        return $this;
    }


    public function get_articles()
    {
        $key = 'article_ids_by_tag_id:'.$this->id;
        $article_ids = $this->mc->get($key);
        if ($article_ids === FALSE)
        {
            $article_ids = array();
            $sql = 'SELECT at.article_id FROM `articles_tags` at WHERE at.tag_id=?';
            $v = array($this->id);
            $rows = $this->mdb->select($sql, $v);
            foreach ($rows as $row)
            {
                $article_ids[] = $row->article_id;
            }
            $this->mc->set($key, $article_ids);
        }
        
        $this->articles = array();
        foreach ($article_ids as $article_id)
        {
            $article = new Article_m($article_id);
            $this->articles[] = $article;
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
            if ( ! in_array($k, array('id', 'uri_seg', 'name')))
            {
                unset($this->$k);
            }
        }
    }
}

/* End of file tag_m.php */
/* Location: ./application/models/tag_m.php */