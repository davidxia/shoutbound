<?php

class Geolocate extends Controller {

	function Maps()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('geo_demo_2');
	}
}

/* End of file geolocate.php */
/* Location: ./system/application/controllers/geolocate.php */