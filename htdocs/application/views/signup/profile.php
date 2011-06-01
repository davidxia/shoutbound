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
	
<body>

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

  <!--CONTENT-->
  <div class="onboarding-main"> 

    <div id="top-section">    
      <!--TOP-->
      <div id="onboarding-top">
        <div class="onboarding-header">1. Dream</div>
        <div class="onboarding-header">2. Follow</div>
        <div class="onboarding-header activeheader">3. Profile</div>    
      </div>
      <div class="onboarding-subtitle">Complete your profile.</div>    
    </div>
  
    <!--LEFT-->
    <div id="onboarding-left">

      <div class="settings-item">
        <div class="settings-item-name">Picture</div>
        <div class="settings-item-content">
          <div id="change-photo">
            <a href="#" id="file_upload" name="file_upload" type="file"></a>
            <div class="subtext">Maximum size: 100KB</div>
            <div id="custom-queue"></div>
          </div>        
          <div id="current-profile-pic" class="profile-pic-container">
            <a href="#" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" width="125" height="125"/></a>
          </div>
        </div>
      </div>
    
      <div class="settings-item">
        <div class="settings-item-name">Web</div>
        <div class="settings-item-content">
          <input type="text" id="website" style="width:275px; height:20px;" value="<?=$user->website?>"/><br/>
          <span class="subtext">Have your own website or blog? Enter the address here.</span>        
        </div>
      </div>        
      
      <div class="settings-item" style="position:relative;">
        <div class="settings-item-name">Current location</div>
        <div class="settings-item-content">
          <input type="text" id="current-place" class="place-input" style="width:275px; height:20px;" value="<? if(isset($user->current_place->name)) echo $user->current_place->name?>"/>
          <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:150px; top:4px;"/>
          <input id="current-place-id" class="place_id" name="current-place-id" type="hidden"/>
          <br/><span class="subtext">Where in the world are you in right now?</span>        
        </div>
      </div>        
      
      <div class="settings-item">
        <div class="settings-item-name">Bio</div>
        <div class="settings-item-content">
          <textarea id="bio" style="width:415px; height:125px;"><?=$user->bio?></textarea><br/>
          <span class="subtext">Describe yourself in 250 characters or less. Characters remaining: <span id="chars-remaining"></span></span>
        </div>
      </div> 
         
    </div><!--LEFT END-->

    <!--RIGHT-->
    <div id="onboarding-right">
      <div id="walkthrough-text">
<!--         Walkthrough text goes here. -->
      </div>
    
    </div><!--RIGHT ENDS-->    
        
    <div style="clear:both"></div>   
  </div><!--CONTENT END-->
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
</div><!--STICK FOOTER WRAPPER ENDS-->
  
  <!--STICKY BAR-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="<?=site_url('signup/follow')?>" class="back-button">Back</a>
      <a href="<?=site_url('signup/finish')?>" class="next-button finish">Take me to Shoutbound!</a>
    </div>
  </div>

</body>
</html>