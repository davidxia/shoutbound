<?php

class Altitoid extends Controller
{
    
    function Friends()
    {
        parent::Controller();
    }


    function index()
    {
        $this->load->view('altitoid');
    }
    
    
    function uploadify()
    {
        $this->load->view('uploadify');
    }    
}

/* End of file altitoid.php */
/* Location: ./application/controllers/altitoid.php */