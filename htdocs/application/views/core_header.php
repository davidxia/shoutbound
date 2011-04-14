<!DOCTYPE html> 
<html> 
  <head>
    <title><?=$title?></title>
    <link rel="shortcut icon" href="<?=site_url('images/favicon.ico')?>">

    <!-- LIBRARIES -->
    <link rel="stylesheet" href="<?=static_url('css/common.css')?>" type="text/css" media="screen" charset="utf-8"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?=static_url('js/jquery/jquery.json.js')?>"></script>

    <!-- PAGE CSS and JAVASCRIPT -->
    <?
    if ($css_paths)
    {
        foreach ($css_paths as $css)
        {
            $css_tag = '<link rel="stylesheet" href="';
            $css_tag .= static_url($css);
            $css_tag .= '" type="text/css" media="screen" charset="utf-8"/>';

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