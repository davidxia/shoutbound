<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
    ),
    'js_paths'=>array(
        'js/profile/edit.js',
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
    
    <h2>Where I've been</h2>
    <form id="been-to-form" action="ajax_save_user_places" method="post">
      <fieldset>
        <div style="display:inline-block; margin-bottom:5px;">Places</div>
        <div style="display:inline-block; margin-left:230px; margin-bottom:5px;">Dates (optional)</div>
        <div id="places_dates" style="position:relative; margin-bottom:10px;">
          <a id="add-place" href="#" style="position:absolute; top:15px; left:-15px; font-size:13px;">[+]</a>
          <a id="subtract-place" href="" style="position:absolute; top:-2px; left:-15px;">[-]</a>
          <div class="field place" style="margin-bottom:10px; float:left; position:relative; width:312px;">
            <span class="label-and-errors">
              <label for="place"></label>
              <span class="error-message" style="float:right;"></span>
            </span>
            <input type="text" id="place" class="place-input" name="place" style="width:300px;" autocomplete=off/>
            <input type="hidden" class="place_id" name="place_id"/>
          </div>
          
          <div class="field dates" style="width:251px; margin-left:325px;">
            <span class="label-and-errors">
              <span class="error-message" style="float:right;"></span>
            </span>
            <label for="date">date</label> <input id="date" class="date" name="date" type="text" size="10"/> 
          </div>
        </div>
        <!--<a id="save-been-to" href="#">Save</a>-->
        <input type="submit" value="submit"/>
      </fieldset>
    </form>
    
    
    <div>
      <span>Change profile picture</span>
      <div id="status-message">Select an image file on your computer (4MB max):</div>
      <a href="#" id="file_upload" name="file_upload" type="file">SELECT FILES</a>
      <div id="custom-queue"></div>
    </div>

      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

  <? $this->load->view('footer')?>
  
</body>
</head>