<?php
class Users extends Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User');
     }
 
    function index()
    {         
        $u = new User();
        $u->get_by_id(3);
        print_r($u->name);
    }   
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */