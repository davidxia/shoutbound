<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function custom_404()
{
    include(APPPATH.'controllers/error.php');
    $error = new Error();
    $error->error_404();
}

/* End of file 404_helper.php */
/* Location: ./system/application/helpers/404_helper.php */