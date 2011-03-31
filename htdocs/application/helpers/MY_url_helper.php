<?php

function static_url($path=null)
{
    return site_url('static/'.$path);
}


function static_sub($path=null)
{
    return 'http://static.shoutbound.com/' . $path;
}