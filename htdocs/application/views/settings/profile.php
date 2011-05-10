<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
        'css/settings.css',
    ),
    'js_paths'=>array(
        'js/settings/profile.js',
        'js/jquery/timeago.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
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
  
    <div id="top-bar">
      <div class="top-bar-header">Manage your Shoutbound account.</div>
    </div>
        
    <div id="col-left">
    
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="<?=site_url('settings')?>">Account</a></li>
          <li class="active"><a href="<?=site_url('settings/profile')?>">Profile</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="profile-tab" class="main-tab-content">
            <div id="picture" class="settings-item">
              <div class="settings-item-name">Picture</div>
              <div class="settings-item-content">
                <div id="change-photo">
                  <a href="#" id="file_upload" name="file_upload" type="file"></a>
                  <div class="subtext">Maximum size: 700KB</div>
                  <div id="custom-queue"></div>
                </div>        
                <div id="current-profile-pic" class="profile-pic-container">
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
                <input type="text" id="current-place" class="place-input" style="width:275px; height:20px;" value="<? if(isset($user->curr_place->name)) echo $user->curr_place->name?>"/>
                <img class="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:150px; top:4px;"/>
                <input id="current-place-id" class="place_id" name="current-place-id" type="hidden"/>
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
  
    <!--<h2>Where I've been</h2>
    <form id="been-to-form">
      <fieldset>
        <div style="display:inline-block; margin-bottom:5px;">Places</div>
        <div style="display:inline-block; margin-left:230px; margin-bottom:5px;">Dates (optional)</div>
        <div class="places_dates" style="position:relative; margin-bottom:10px;">
          <a id="add-place" href="#" style="position:absolute; top:15px; left:-15px; font-size:13px;">[+]</a>
          <a id="subtract-place" href="" style="position:absolute; top:-2px; left:-15px;">[-]</a>
          <div class="field place" style="margin-bottom:10px; float:left; position:relative; width:312px;">
            <span class="label-and-errors">
              <label for="place"></label>
              <span class="error-message" style="float:right;"></span>
            </span>
            <input id="place" class="place-input" name="place" type="text" style="width:300px;" autocomplete="off"/>
            <img class="loading-places" src="<?=site_url('images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:10px; top:7px;"/>
            <input id="place_id" class="place_id" name="place_id" type="hidden"/>
          </div>
          
          <div class="field dates" style="width:251px; margin-left:325px;">
            <span class="label-and-errors">
              <span class="error-message" style="float:right;"></span>
            </span>
            <label for="date">date</label> <input id="date" class="date" name="date" type="text" size="10"/> 
          </div>
        </div>
        <input type="submit" id="save-been-to" value="Save"/>
      </fieldset>
    </form>
    
    <div>
      <? foreach($user->places as $place):?>
      <div>
        <?=$place->name?> <abbr class="timeago" title="<?=$place->timestamp?>"><?=$place->timestamp?></abbr>
      </div>
      <? endforeach;?>
    </div>-->
    
      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('footer')?>
  
<script type="text/javascript">
/*$(function() {
  $('abbr.timeago').timeago();
});*/
/*$(function() {
  $('.loading-places')
    .hide()
    .ajaxStart(function() {
      $(this).show();
    })
    .ajaxStop(function() {
      $(this).hide();
    })
  ;
});*/
</script>
</body>
</head>