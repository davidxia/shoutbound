<?php
class Trip extends DataMapper {
    
    public $has_many = array('user');
    
    public function __construct()
    {
        // model contructor
        parent::__construct();
    }

}