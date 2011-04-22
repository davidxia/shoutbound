<?php

function static_url($path=NULL)
{
    return site_url('static/'.$path);
}


function static_sub($path=NULL)
{
    return 'http://static.shoutbound.com/' . $path;
}