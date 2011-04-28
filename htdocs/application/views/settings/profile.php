<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
        'css/settings.css',
    ),
    'js_paths'=>array(
        'js/profile/edit.js',
        'js/jquery/timeago.js',
        'js/jquery/jquery-dynamic-form.js',
        'js/jquery/validate.min.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
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
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
    
    
    <div id="col-left">
    
      <div id="left-content-container">
        <div id="main-tab-container" class="tab-container">

    <!--DAVID, START COPY AND PASTE HERE-->
      <div id="account-tab" class="main-tab-content"> 
        
        <div id="picture" class="settings-item">
          <div class="settings-item-name">Picture</div>
          <div class="settings-item-content">
            <div id="current-profile-pic" class="profile-pic-container">
              <!--<a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="125" height="125"/></a>-->
              <!--DAVID NEEDED TO MAKE PHOTO WORK-->            
            </div>
            <div id="change-photo">
              <a href="#" id="file_upload" name="file_upload" type="file"></a>
              <div class="subtext">Maximum size: 700kb</div>
              <div id="custom-queue"></div><!--DAVID NEEDED - PLS CONFIRM PHOTO UPLOAD/CHANGE WORKS-->
            </div>        
          </div>
          <div style="clear:both"></div>
        </div>
        
        <div id="web" class="settings-item">
          <div class="settings-item-name">Web</div>
          <div class="settings-item-content">
            <fieldset>
              <input type="text" id="url" style="width:275px; height:20px;" value="<?=$user->url?>"/>                        
            </fieldset>
            <span class="subtext">Have your own website or blog? Put the address here.</span>        
          </div>
        </div>        
               
        <div style="clear:both"></div>                      

        <div id="location" class="settings-item">
          <div class="settings-item-name">Current location</div>
          <div class="settings-item-content">
            <fieldset>
              <input type="text" id="location" style="width:275px; height:20px;" value="<? if (isset($user->place)) echo $user->place->name?>"/><!--DAVID NEEDED TO MAKE LOCATION SEARCH WORK-->                        
              </fieldset> 
            <span class="subtext">Where in the world are you in right now?</span>        
          </div>
        </div>        
               
        <div style="clear:both"></div>   

        <div id="bio" class="settings-item">
          <div class="settings-item-name">Bio</div>
          <div class="settings-item-content">
            <fieldset>
              <textarea id="bio" style="width:415px; height:125px;"><?=$user->bio?></textarea>                        
            </fieldset>
            <span class="subtext">Describe yourself in 250 characters or less. Characters remaining: DAVID</span><!--DAVID, PLEASE INSERT CHARACTER COUNTER HERE-->       
          </div>
        </div> 
        
        <div style="clear:both"></div>
                           
       <div id="save-settings-container">
          <input type="submit" id="save-profile" value="Save" class="save-settings-button"/><!--DAVID NEEDED - THIS BUTTON NEEDS TO SAVE ALL THE FIELDS, RIGHT NOW JUST SAVES URL FIELD-->
        </div>
             
      </div>
      <!--DAVID, STOP COPY AND PASTE HERE-->
      
      </div>
      </div>
  
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
            <input id="place_id" class="place_id" name="place_id"type="hidden"/>
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