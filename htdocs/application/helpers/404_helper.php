<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function custom_404()
{
    $CI =& get_instance();
    $CI->output->set_status_header('404');
    $CI->load->view('404');
    return;
}

/* End of file 404_helper.php */
/* Location: ./system/application/helpers/404_helper.php */