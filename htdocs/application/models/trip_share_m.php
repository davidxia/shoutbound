<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trip_share_m extends CI_Model
{
    public $trip_id;
    public $share_key;
    public $share_role;
    public $share_medium;
    public $target_id;
    public $is_claimed;
    
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
        $key = 'trip_share_by_trip_share_id:'.$id;
        $trip_share = $this->mc->get($key);
        
        if ($trip_share === FALSE)
        {
            $sql = 'SELECT * FROM `trip_shares` WHERE id = ?';
            $v = array($id);
            $rows = $this->mdb->select($sql, $v);
            $trip_share = (isset($rows[0])) ? $rows[0] : NULL;
            $this->mc->set($key, $trip_share);
        }
        
        $this->row2obj($trip_share);
        return $this;
    }
    
    
    public function create($params = array())
    {
        $trip_id = (isset($params['trip_id'])) ? $params['trip_id'] : NULL;
        $share_role = (isset($params['share_role'])) ? $params['share_role'] : NULL;
        $share_medium = (isset($params['share_medium'])) ? $params['share_medium'] : NULL;
        $target_id = (isset($params['target_id'])) ? $params['target_id'] : NULL;
        $share_key = md5($trip_id.rand(1000000,99999999).$target_id);
        $is_claimed = 0;

        if (!isset($trip_id) OR !isset($share_role))
        {
            return FALSE;
        }

        $sql = 'INSERT INTO `trip_shares` (`trip_id`, `share_key`, `share_role`, `share_medium`, `target_id`, `is_claimed`) VALUES (?,?,?,?,?,?)';
        $values = array($trip_id, $share_key, $share_role, $share_medium, $target_id, $is_claimed);
        $r = $this->mdb->alter($sql, $values);
        if ($r['num_affected'] == 1)
        {
            $this->id = $r['last_insert_id'];
            $this->trip_id = $trip_id;
            $this->share_role = $share_role;
            $this->share_medium = $share_medium;
            $this->target_id = $target_id;
            $this->share_key = $share_key;
            $this->is_claimed = $is_claimed;
            return TRUE;
        }

        return FALSE;
    }

/*

    public function get_tripshare_by_tripid_sharekey($trip_id, $share_key)
    {
        //$key = 'tripshare_by_idhash:'.$trip_id.':'.$share_key;
        //$ts = $this->mc->get($key);
        //if ($ts === FALSE)
        //{
            $ts = new Trip_share_m();
            $ts->limit(1)->get_where(array('trip_id' => $trip_id, 'share_key' => $share_key, 'is_claimed' => 0));
            if ($ts->id)
            {
                $ts->where('id', $ts->id)->update('is_claimed', 1);
                return $ts->stored;
            }
            else
            {
                $ts->limit(1)->get_where(array('trip_id' => $trip_id, 'share_key' => $share_key, 'is_claimed' => -1));
                if ($ts->id)
                {
                    //$this->mc->set($key, $ts->stored);
                    return $ts->stored;
                }
                else
                {
                    return FALSE;
                }
            }
        //}
        //return $ts;        
    }
*/
    
    
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

/* End of file trip_share_m.php */
/* Location: ./application/models/trip_share_m.php */