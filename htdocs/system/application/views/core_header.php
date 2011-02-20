<!DOCTYPE html> 
<html> 
    <head>
        <title>ShoutBound</title>

        <!-- LIBRARIES -->
        <link rel="stylesheet" type="text/css" href="<?php echo static_url('css/main.css');?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo static_url('css/960grid.css');?>"/>
        <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery.js');?>"></script>
        <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery.json.js');?>"></script>
        <script type="text/javascript" src="<?php echo static_url('js/jquery/popup.js');?>"></script>

        <!-- PAGE CSS and JAVASCRIPT -->
        <?php
        if($css_paths) {
            foreach($css_paths as $css) {
                $css_tag = '<link rel="stylesheet" type="text/css" href="';
                $css_tag .= static_url($css);
                $css_tag .= '"/>';
    
                echo($css_tag);
            }
        }

        // external JS files
        if($js_paths) {
            foreach($js_paths as $js) {
                $js_tag = '<script type="text/javascript" src="';
                $js_tag .= static_url($js);
                $js_tag .= '">';
                $js_tag .= '</script>';
    
                echo($js_tag);
            }
        }
        ?>