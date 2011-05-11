<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function json_error($message = NULL)
{
    echo json_encode(array('success' => 0, 'message' => $message));
}

function json_success($array = array())
{
    echo json_encode(array_merge(array('success' => 1), $array));
}
/* End of file ajax_helper.php */
/* Location: ./system/application/helpers/ajax_helper.php */