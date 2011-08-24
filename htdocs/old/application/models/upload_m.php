<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_m extends CI_Model
{    

    function __construct($id = NULL)
    {
        parent::__construct();
        if (is_int($id))
        {
            $this->get_by_id($id);
        }
    }
    
    
    public function get_by_id($id)
    {
        $key = 'upload_by_upload_id:'.$id;
        $upload = $this->mc->get($key);
        if ($upload === FALSE)
        {
            $sql = 'SELECT * FROM `uploads` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $upload = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $upload);
        }

        $this->row2obj($upload);
    }
    


    public function row2obj($row)
    {
        if ( ! is_null($row))
        {
            foreach (get_object_vars($this) as $k => $v)
            {
                $this->$k = $row->$k;
            }    
        }
    }


}

/* End of file upload_m.php */
/* Location: ./application/models/upload_m.php */