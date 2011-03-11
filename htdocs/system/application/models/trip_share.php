<?php

class Trip_share extends DataMapper
{
 
    public $has_one = array('trip');

    var $validation = array(
        array(
            'field' => 'trip_id',
            'label' => 'Trip',
            'rules' => array('required')
        ),
        array(
            'field' => 'share_key',
            'label' => 'Share Key',
            'rules' => array('required')
        ),
        array(
            'field' => 'share_role',
            'label' => 'Share Role',
            'rules' => array('required')
        ),
        array(
            'field' => 'share_medium',
            'label' => 'Share Medium',
            'rules' => array('required')
        ),
        array(
            'field' => 'target_id',
            'label' => 'Target',
            'rules' => array('required')
        ),
    );

    function Trip_share()
    {
        parent::DataMapper();
    }
    
    
    function generate_share_key()
    {
        //$ts = new Trip_share();
        //$ts->trip_id = $this->trip_id;
        
        $salt = rand(1000000,99999999);
        $this->share_key = md5($this->trip_id.$salt.$this->target_id);
        //$ts->share_role = $this->input->post('shareRole');
        //$ts->share_medium = $this->input->post('shareMedium');
        //$ts->target_id = $this->input->post('targetId');
        
        if ($this->save())
        {
            return $this->share_key;
        }
        
        return FALSE;
    }


    function get_tripshare_by_tripid_sharekey($trip_id, $share_key)
    {
        //$key = 'tripshare_by_idhash:'.$trip_id.':'.$share_key;
        //$ts = $this->mc->get($key);
        //if ($ts === FALSE)
        //{
            $ts = new Trip_share();
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
}

/* End of file trip_share.php */
/* Location: ./application/models/trip_share.php */