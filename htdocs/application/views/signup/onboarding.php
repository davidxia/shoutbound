<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/uploadify.css',
        'css/onboarding.css',
    ),
    'js_paths' => array(
        'js/common.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/settings/profile.js',
        'js/follow.js',
        'js/user/loginSignup.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/jquery-dynamic-form.js',
        'js/jquery/validate.min.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var uid = <?=$user->id?>;
</script>
</head>
	
<body style="overflow-y: hidden; overflow-x:hidden;">

  <!--CONTENT-->
  <div class="onboarding-main"> 
    
    <!--TOP-->
    <div id="onboarding-top">
      <div class="onboarding-header activeheader">1. Dream</div>
      <div class="onboarding-header">2. Follow</div>
      <div class="onboarding-header">3. Profile</div>    
    </div>
    
    <!--LEFT-->
    <div id="onboarding-left">
      <div class="onboarding-subtitle">What are your dream travel destinations?</div>
      <fieldset>
        <input type="text" id="address" class="destination-input" name="address" autocomplete=off />
      </fieldset>              
    </div>
    
    <!--MAP-->
    <div id="map-shell">
      <div id="map-canvas">
        <img src="<?=site_url('static/images/map_placeholder.png')?>" width="490" height="390"/>
      </div>
    </div>
           
    <div style="clear:both"></div>
    
  </div><!--CONTENT END-->

  <!--STICKY-BAR-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="<?=site_url('signup/follow')?>" class="next-button">Next</a> 
    </div>        
  </div>

</body>
</html>