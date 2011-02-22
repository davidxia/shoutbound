<?php
class Course extends DataMapper {
 
    public $has_many = array('student');
 
    public function __construct()
    {
        // model constructor
        parent::__construct();
    }
}