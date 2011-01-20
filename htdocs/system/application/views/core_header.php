<!DOCTYPE html> 
<html> 
<head>
    
<title>noqnok</title>

<!-- LIBRARIES -->
<!--<link rel="stylesheet" type="text/css" href='<?=static_url('css/noqnok.css');?>'/>-->
<script type="text/javascript" src="<?=static_url('js/jquery/jquery-dev.js');?>"></script>
<script language="javascript" src="<?=static_url('js/jquery/jquery.json.js');?>"></script>
<script language="javascript" src="<?=static_url('js/jquery/popup.js');?>"></script>
<script language="javascript" src="<?=static_url('js/jquery/jquery.tmpl.js');?>"></script>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
    Constants = {};
    Constants["staticUrl"] = "<?=static_url("")?>";
    Constants["siteUrl"] = "<?=site_url("")?>";
    Constants["tripId"] = "<?=static_url("")?>";
    Constants["userId"] = "<?=static_url("")?>";
</script>


<!-- PAGE CSS and JAVASCRIPT -->
<?

if($css_paths) {
    foreach($css_paths as $css) {
        $css_tag = '<link rel="stylesheet" type="text/css" href="';
        $css_tag .= static_url($css);
        $css_tag .= '"/>';
    
        echo($css_tag);
    }
}

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
