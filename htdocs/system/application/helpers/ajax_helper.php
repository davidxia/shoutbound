<?php

function json_error($message = NULL)
{
    echo json_encode(array('success' => 0, 'message' => $message));
}

function json_success($array = array())
{
    echo json_encode(array_merge(array('success' => 1), $array));
}

//TODO: dump this in its own file
function first_name($full_name)
{
    $a = explode(' ', $full_name);
    return $a[0];
}

/* End of file ajax_helper.php */
/* Location: ./system/application/helpers/ajax_helper.php */