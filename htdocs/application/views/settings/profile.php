<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/settings.css',
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/settings/profile.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<style type="text/css">
  table.ui-datepicker-calendar{
    display:none;
  }
</style>
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
  
    <div id="top-bar">
      <div class="top-bar-header">Manage your Shoutbound account.</div>
    </div>
        
    <div id="col-left">
    
      <div id="left-content-container">
      
        <ul id="tab-style">
          <li><a href="<?=site_url('settings')?>">Account</a></li>
          <li class="active">Profile</li>
          <li><a href="<?=site_url('settings/trail')?>">Trail</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="profile-tab" class="main-tab-content">
            <div id="picture" class="settings-item">
              <div class="settings-item-name">Picture</div>
              <div class="settings-item-content">
                <div id="change-photo">
                  <a href="#" id="file_upload" name="file_upload" type="file"></a>
                  <div class="subtext">Maximum size: 100KB</div>
                  <div id="custom-queue"></div>
                </div>        
                <div id="profile-pic-container">
                  <a href="<?=static_sub('profile_pics/'.$user->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" width="125" height="125"/></a>
                </div>
              </div>
            </div>

            <div class="settings-item">
              <div class="settings-item-name">Bio</div>
              <div class="settings-item-content">
                <textarea id="bio" style="width:375px; height:125px;"><?=$user->bio?></textarea><br/>
                <span class="subtext">Describe yourself in 250 characters or less. Characters remaining: <span id="chars-remaining"></span></span>
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
                <input type="text" id="current-place" class="place-input" style="width:275px; height:20px;" value="<? if(isset($user->current_place->name)){echo $user->current_place->name;if($user->current_place->admin1){echo ', '.$user->current_place->admin1;}if($user->current_place->country){echo ', '.$user->current_place->country;}}?>"/>
                <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:140px; top:24px;"/>
                <input id="current-place-id" class="place_id" name="current-place-id" type="hidden" val="<? if(isset($user->current_place->id)){echo $user->current_place->id;}?>"/>
                <br/><span class="subtext">Where in the world are you in right now?</span>        
              </div>
            </div>
                                           
            <div id="save-settings-container">
              <input type="submit" id="save-profile" value="Save" class="save-settings-button"/>
              <span id="save-response" class="response"></span>
            </div>
          </div><!-- PROFILE TAB ENDS -->
      
        </div><!-- TAB CONTAINER ENDS -->
      </div><!-- LEFT CONTENT CONTAINER ENDS -->    
      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body>
</head>