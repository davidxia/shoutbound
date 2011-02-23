<?php
class Friend extends DataMapper {
 
    public $has_one = array('user');
    
    var $validation = array(
        array(
            'field' => 'friend_fid',
            'label' => 'friend_fid',
            'rules' => array('required')
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => array('required')
        )
    );
    
    function Friend()
    {
        parent::DataMapper();
    }
}

/* End of file friend.php */
/* Location: ./application/models/friend.php */