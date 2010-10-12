<?php

class Maps extends Controller {

	function Maps()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('google_maps_demo');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */