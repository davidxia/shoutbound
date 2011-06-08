<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/uploadify.css',
        'css/onboarding.css',
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/common.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/settings/profile.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticUrl = '<?=static_sub()?>';
  var uid = <?=$user->id?>;
</script>
</head>
	
<body>

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

  <!--LEFT NAVBAR-->
  <ul id="onboarding-navbar">
    <li>Dream</li>
    <li>Follow</li>
    <li class="activeheader">Profile</li>
    <li class="filler"></li>
  </ul>
  <!--LEFT NAVBAR END-->

  <!--MAIN-->
  <div class="onboarding-main">
    <div id="onboarding-subtitle">Complete your profile.</div>
    <div id="onboarding-copy"><strong>Pick a memorable username and complete your profile.</strong> Your profile will be at www.shoutbound.com/yourusername! Your username should be between 3 and 15 characters long. </div>
    
      <div class="settings-item" style="padding-top:10px !important">
        <div class="settings-item-name">Username</div>
        <div class="settings-item-content" style="position:relative; width:650px !important;">
          <input style="margin-left:-2px; padding-left:108px; width:190px;" type="text" id="username" maxlength="15" value="<?=$user->username?>"/>
          <div id="shoutbound-url" style="display:inline; position:relative; left:-300px; width:75px; font-size:13px; color:#777;">shoutbound.com/</div>
          <img class="ajax-spinner" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="display:none;position:absolute;left:280px;top:3px;"/>
          <span id="username-help" style="position:relative; left:-100px; color:#777; width:300px; font-weight:bold;"></span>
          <br/>
        </div>
      </div>        

      <div class="settings-item">
        <div class="settings-item-name">Picture</div>
        <div class="settings-item-content">
          <div id="current-profile-pic" class="profile-pic-container">
            <a href="<?=static_sub('profile_pics/'.$user->profile_pic)?>"><img id="profile-pic" src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" width="125" height="125"/></a>
          </div>
          <div id="change-photo">
            <a href="#" id="file_upload" name="file_upload" type="file"></a>
            <div class="subtext">Maximum size: 100KB</div>
            <div id="custom-queue"></div>
          </div>
          <div style="clear:both"></div>                  
        </div>
      </div>
    
      <div class="settings-item">
        <div class="settings-item-name">Website</div>
        <div class="settings-item-content">
          <input type="text" id="website" style="width:275px; height:20px;" value="<?=$user->website?>"/>
          <div class="subtext">Have your own website or blog? Enter the address here.</div>        
        </div>
      </div>        
      
      <div class="settings-item" style="position:relative;">
        <div class="settings-item-name">Current location</div>
        <div id="current-place" class="settings-item-content">
          <input type="text" id="current-place-input" class="place-input" style="width:275px; height:20px;" value="<? if(isset($user->current_place->name)) echo $user->current_place->name?>"/>
          <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:160px; top:25px;"/>
          <input id="current-place-id" class="place_id" name="current-place-id" type="hidden"/>
          <div class="subtext">Where in the world are you in right now?</div>        
        </div>
      </div>        
      
      <div class="settings-item">
        <div class="settings-item-name">Bio</div>
        <div class="settings-item-content">
          <textarea id="bio" style="width:415px; height:125px;"><?=$user->bio?></textarea><br/>
          <span class="subtext">Describe yourself in 250 characters or less. Characters remaining: <span id="chars-remaining"></span></span>
        </div>
      </div> 
         
        
    <div style="clear:both"></div>   
    
  </div><!--MAIN END-->
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
</div><!--STICK FOOTER WRAPPER ENDS-->
  
  <!--STICKY BAR-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="<?=site_url('signup/follow')?>" class="back-button">Back</a>
      <a href="#" id="finish-onboarding" class="next-button finish">Take me to Shoutbound!</a>
    </div>
  </div>

<script type="text/javascript">
  $('#finish-onboarding').click(function() {
    var username = $('#username'),
        bio = $('#bio'),
        website = $('#website'),
        currPlaceId = $('#current-place-id').val();
    
    var websiteVal = website.val();
    if (website.val() && !websiteVal.match(/^[a-zA-Z]+:\/\//)) {
      websiteVal = 'http://' + websiteVal;
    }

    $.post(baseUrl+'users/ajax_save_profile', {username:username.val(), bio:bio.val(), website:websiteVal, currPlaceId:currPlaceId},
      function(d) {
        var r = $.parseJSON(d);
        if (r.changed == 1) {
          window.location = '<?=site_url('signup/finish')?>';
        }
      });
    return false;
  });
</script>
</body>
</html>