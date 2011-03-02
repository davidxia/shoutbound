<!DOCTYPE html> 
<html> 
  <head>
    <title>ShoutBound</title>

    <!-- LIBRARIES -->
    <link rel="stylesheet" href="<?php echo static_url('css/common.css');?>" type="text/css" media="screen" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery.js');?>"></script>
    <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery.json.js');?>"></script>

    <!-- PAGE CSS and JAVASCRIPT -->
    <?
    if ($css_paths)
    {
        foreach ($css_paths as $css)
        {
            $css_tag = '<link rel="stylesheet" type="text/css" href="';
            $css_tag .= static_url($css);
            $css_tag .= '"/>';

            echo($css_tag);
        }
    }

    // external JS files
    if ($js_paths)
    {
        foreach ($js_paths as $js)
        {
            $js_tag = '<script type="text/javascript" src="';
            $js_tag .= static_url($js);
            $js_tag .= '">';
            $js_tag .= '</script>';

            echo($js_tag);
        }
    }
    ?>