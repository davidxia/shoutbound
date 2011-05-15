<?
$header_args = array(
    'title' => 'Onboarding | Shoutbound',
    'css_paths' => array(
        'css/uploadify.css',
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
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
  
  <div class="settings-item">
    <div class="settings-item-name">Picture</div>
    <div class="settings-item-content">
      <div id="change-photo">
        <a href="#" id="file_upload" name="file_upload" type="file"></a>
        <div class="subtext">Maximum size: 100KB</div>
        <div id="custom-queue"></div>
      </div>        
      <div id="current-profile-pic" class="profile-pic-container">
        <a href="<?=static_sub('profile_pics/'.$user->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" width="125" height="125"/></a>
      </div>
    </div>
  </div>

  <div class="settings-item">
    <div class="settings-item-name">Web</div>
    <div class="settings-item-content">
      <input type="text" id="url" style="width:275px; height:20px;" value="<?=$user->url?>"/><br/>
      <span class="subtext">Have your own website or blog? Put the address here.</span>        
    </div>
  </div>        
  
  <div class="settings-item" style="position:relative;">
    <div class="settings-item-name">Current location</div>
    <div class="settings-item-content">
      <input type="text" id="current-place" class="place-input" style="width:275px; height:20px;" value="<? if(isset($user->curr_place->name)) echo $user->curr_place->name?>"/>
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
  
  <div id="save-settings-container">
    <input type="submit" id="save-profile" value="Save" class="save-settings-button"/>
    <span id="save-response"></span>
  </div>


  <? if ($user->following):?>
    We've automatically followed for you these people on Shoutbound whom we think are your friends and the trips they're planning.
  <? endif;?>
  <? foreach ($user->following as $following):?>
  <div>
    <a href="<?=site_url('profile/'.$following->id)?>" target="_blank"><?=$following->name?></a>
    <a class="unfollow" id="user-<?=$following->id?>" href="#">Unfollow</a>
    <? foreach ($following->trips as $trip):?>
    <div style="margin-left:20px;">
      <a href="<?=site_url('trips/'.$trip->id)?>" target="_blank"><?=$trip->name?></a>
      <? foreach ($trip->goers as $goer):?>
      <a href="<?=site_url('profile/'.$goer->id)?>" target="_blank"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="35" height="35" alt="<?=$goer->name?>"/>
      <? endforeach;?>
      <a class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a>
    </div>
    <? endforeach;?>
  </div>
  <? endforeach;?>
  
  <a href="<?=site_url()?>">Finished</a>
  
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('footer')?>
</body>
</html>