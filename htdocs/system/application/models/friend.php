<?php
class Friend extends DataMapper {
 
    public $has_many = array('user');
    
    var $validation = array(
        array(
            'field' => 'facebook_id',
            'label' => 'Facebook Id',
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