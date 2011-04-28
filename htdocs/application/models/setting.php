<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends DataMapper
{
    public $has_many = array('user');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    
    
    public function get_settings()
    {
        $this->order_by('id', 'asc')->get_iterated();
        $settings = array();
        foreach ($this as $setting)
        {
            $settings[] = $setting->stored;
        }
        return $settings;
    }
}

/* End of file setting.php */
/* Location: ./application/models/setting.php */