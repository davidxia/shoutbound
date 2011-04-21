<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css',
        'css/excite-bike/jquery-ui-1.8.10.custom.css',
    ),
    'js_paths'=>array(
        'js/jquery/jquery-dynamic-form.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/jquery/jquery-ui-1.8.10.custom.min.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
    
    <h2>Where I've been</h2>
    <form id="been-to-form" action="places_test" method="post">
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
            <input type="hidden" name="id"/>
          </div>
          
          <div class="field dates" style="width:251px; margin-left:325px;">
            <span class="label-and-errors">
              <span class="error-message" style="float:right;"></span>
            </span>
            <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> 
            <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10"/>
          </div>
        </div>
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
  
<script type="text/javascript">
$(function() {
  $('#file_upload').uploadify({
    'uploader'       : baseUrl+'static/js/uploadify/uploadify.swf',
    'script'         : baseUrl+'profile/profile_pic_uploadify',
    'scriptData'     : {'uid':<?=$user->id?>},
    'cancelImg'      : baseUrl+'images/cancel.png',
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'auto'           : true,
    'sizeLimit'      : 32000000,
    'fileExt'        : '*.jpg;*.gif;*.png',
    'fileDesc'       : 'Image Files'
  });
});


// dynamic form plugin for multiple destinations
$('#places_dates').dynamicForm('#add-place', '#subtract-place', {
  limit: 5,
  afterClone: function(clone) {
    // TODO: why doesn't this work?
    clone.find('.place-input').focus();
  }
});


// datepicker jquery plugin
$('.startdate').live('focus', function() {
  $(this).datepicker();
});
$('.enddate').live('focus', function() {
  $(this).datepicker();
});


// jquery form validation plugin
$('#been-to-form').validate({
  rules: {
    startdate: {
      date: true
    },
    enddate: {
      date: true
    }
  },
  errorPlacement: function(error, element) {
    error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
  }
});
</script>

</body>
</head>