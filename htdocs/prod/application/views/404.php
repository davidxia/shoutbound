<?php
$header_args = array(
    'title' => 'nom nom nom | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/jquery/jquery.form.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
  
</head>
<body>
   
  <div style="margin:45px auto 0px auto; width:800px; border-bottom:1px solid #CACACA; padding-bottom:25px;">
    <div style="font-size:30px; font-weight:bold; line-height:32px; border-bottom:1px solid #CACACA; padding-bottom:10px; margin-bottom:15px;">Oh no! My cousin ate the page you ordered.</div>       
    <div style="float:right; width:400px; padding:8px; background-color: #EDEFF4; box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2); -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2); text-align:center;">
      <img style="margin-bottom:3px;" src="<?=static_subdom('chenchen_face_small.jpg')?>" width="400" height="345"/>       
      <br><em>&ldquo;Sorry I ate your page&rdquo; - Chen Chen.</em>
    </div>
    <div style="width:360px;">
      My cousin Chen Chen eats web pages when he gets hungry. He might have eaten the one you&rsquo;re looking for.<br><br>If you think you&rsquo;ve found something broken with Shoutbound, please tell us what you were trying to do when you ended up on this page so we can fix it ASAP:<br>        
      <form id="bug-report-form" method="post" action="<?=site_url('error/bug_report')?>">
        <textarea name="bug-report" id="bug-report" style="width:350px; margin:8px 0px 0px; height:80px;"></textarea>       
        <input type="submit" class="submit" value="Submit" style="padding:0;height:30px;"/>
      </form>
      <div id="bug-submit-response"><span></span></div>
      
      <div style="margin-top:93px; padding:10px 8px; background-color:#EDEFF4;text-align:center;">
        <a href="<?=site_url()?>" class="save-settings-button" style="height:35px; line-height:35px; padding:10px 8px;">Take me back to Shoutbound!</a>
      </div>       
    </div>
  </div>

</body>
<script type="text/javascript">
$(function(){
  function showResponse(r){ 
    if (r.success){
      $('#bug-submit-response').find('span').animate({opacity:0}, 200, function(){
        $(this).text('Bug report sent.').animate({opacity:1});
      });
      $('#bug-report').val('');
    }
  }

  var options = { 
    success: showResponse,
    dataType: 'json'
  };
  $('#bug-report-form').ajaxForm(options);
});
</script>
</html>