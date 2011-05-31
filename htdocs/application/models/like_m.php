<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Like_m extends CI_Model
{
    public $id;
    public $user_id;
    public $post_id;
    public $is_like;
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
        $key = 'like_by_like_id:'.$id;
        $like = $this->mc->get($key);
        
        if ($like === FALSE)
        {
            $sql = 'SELECT * FROM `likes` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $like = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $like);
        }

        $this->row2obj($like);
        return $this;
    }
    
    
    public function set_like($is_like = 1)
    {
        $sql = 'UPDATE `likes` SET is_like = ? WHERE id = ?';
        $v = array($is_like, $this->id);
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

/* End of file like_m.php */
/* Location: ./application/models/like_m.php */