<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dedup(&$array)
{
    $ids = array();
    
    foreach ($array as $key => $val)
    {
        if (in_array($val->id, $ids))
        {
            unset($array[$key]);
        }
        else
        {
            $ids[] = $val->id;
        }
    }
    $array = array_values($array);
}


/* End of file dedup_helper.php */
/* Location: ./system/application/helpers/dedup_helper.php */