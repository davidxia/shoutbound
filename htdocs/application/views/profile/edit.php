<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
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
    
    <h2>Edit profile</h2>
    <form id="edit-profile" action="">
      <fieldset>
        <label for="location">Current location</label>
        <input type="text" id="location" value="<?=$user->place->name?>"/>
        <br/>
        <label for="bio" style="vertical-align:top;">Bio</label>
        <textarea id="bio" style="width:350px; height:100px;"><?=$user->bio?></textarea>
        <br/>
        <label for="url">Website</label>
        <input type="text" id="url" value="<?=$user->url?>"/>
      </fieldset>
      <input type="submit" id="save-profile" value="Save"/>
    </form>
    
    <h2>Where I've been</h2>
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
    </div>
    
    
    <div>
      <span>Change profile picture</span>
      <div id="status-message">Select an image file on your computer (4MB max):</div>
      <a href="#" id="file_upload" name="file_upload" type="file">SELECT FILES</a>
      <div id="custom-queue"></div>
    </div>

      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

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