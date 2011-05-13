<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function static_url($path=NULL)
{
    return site_url('static/'.$path);
}


function static_sub($path=NULL)
{
    return 'http://static.shoutbound.com/'.$path;
}


/* End of file MY_url_helper.php */
/* Location: ./system/application/helpers/MY_url_helper.php */