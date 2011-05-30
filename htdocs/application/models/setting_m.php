<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_m extends CI_Model
{
    public $id;
    public $name;
    public $description;    

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
        $key = 'setting_by_setting_id:'.$id;
        $setting = $this->mc->get($key);
        if ($setting === FALSE)
        {
            $sql = 'SELECT * FROM `settings` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $setting = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $setting);
        }

        $this->row2obj($setting);
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

/* End of file setting_m.php */
/* Location: ./application/models/setting_m.php */