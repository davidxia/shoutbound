<?php


function static_url($path)
{
    return site_url('static/'.$path);
}


function static_sub($path=null)
{
    return 'http://static.shoutbound.com/' . $path;
}