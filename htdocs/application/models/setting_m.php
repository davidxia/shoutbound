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
    
    
    public function get_all_settings()
    {
        $key = 'all_setting_ids';
        $all_setting_ids = $this->mc->get($key);
        
        if ($all_setting_ids === FALSE)
        {
            $all_setting_ids = array();
            $sql = 'SELECT id FROM `settings` ORDER BY `id` ASC';
            $rows = $this->mdb->select($sql);
            foreach ($rows as $row)
            {
                $all_setting_ids[] = $row->id;
            }
            $this->mc->set($key, $all_setting_ids);
        }
        
        $settings = array();
        foreach ($all_setting_ids as $setting_id)
        {
            $settings[] = new Setting_m($setting_id);
        }
        
        return $settings;
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