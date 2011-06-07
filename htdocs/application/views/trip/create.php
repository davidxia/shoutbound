<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
        'css/createtrip.css',
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/user/loginSignup.js',
        'js/jquery/validate.min.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/jquery/popup.js',
        'js/jquery/jquery-dynamic-form.js'
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var swLat = -50;
  var swLng = -180;
  var neLat = 50;
  var neLng = 180;
</script>

</head>

<body>

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
		  
  <div id="top-section">
    <div id="top-bar">
      <div class="top-bar-header" style="font-size:20px;font-weight:bold;">New trip</div>
    </div>
  </div>

  <div id="col-left">
    <div id="left-content-container">
      <!-- TRIP CREATION FORM -->
      <form id="trip-creation-form" action="<?=site_url('trips/confirm_create')?>" method="post">
        
        <!-- PLACE DATES FIELD -->
        <fieldset class="settings-item">
          <div style="display:inline;">Destinations</div>
          <div id="dates-header" style="display:inline-block;margin-left:215px;margin-bottom:10px;">Dates (optional)</div>
          
          <div id="place_dates" style="position:relative;width:550px;margin-bottom:15px;">
            <a id="add-place" href="#" style="position:absolute;left:-20px;top:-5px;">[+]</a>
            <a id="subtract-place" href="#" style="position:absolute;left:-20px;top:10px;">[-]</a>
            
            <div class="field place" id="place" style="float:left;">
              <span class="label-and-errors">
                <label for="place_name0"></label>
                <span class="error-message" style="float:right;"></span>
              </span>
              <input type="text" id="place_name" class="place-input" name="place_name" autocomplete=off style="width:275px;"/>
              <input type="hidden" id="place_id" class="place_ids" name="place_id"/>
            </div>
            
            <div class="field dates" style="visibility:hidden;float:left;margin-left:15px;">
              <span class="label-and-errors">
                <span class="error-message"></span>
                <div class="clear"></div>
              </span>
              <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10" />
            </div>
            <div style="clear:both"></div>
          </div>
        </fieldset><!-- PLACE DATES FIELD ENDS -->
        
        <!-- SUMMARY FIELD -->
        <fieldset id="summary-field" style="margin-top:20px;">
          <div class="field trip_name">
            <span class="label-and-errors">
              <label for="trip_name">Trip name</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <input id="trip_name" name="trip_name" class="required" type="text" style="width:515px;" value="<?=$user->first_name?>'s Trip to"/>
          </div>
          <div class="field" style="margin-top:20px;">
            <span class="label-and-errors">
              <label for="description">Trip description</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <textarea id="description" name="description" style="width:515px;"></textarea>
          </div>
        </fieldset><!-- SUMMARY  FIELD ENDS -->
    
        <div id="save-settings-container">
          <button id="create-submit" type="submit">Create</button>
        </div>
      </form><!-- TRIP CREATION FORM ENDS -->
    </div><!--LEFT CONTENT CONTAINER--> 
  </div><!--LEFT COLUMN END-->

  <!-- RIGHT COLUMN -->
  <div id="col-right">
    <div id="right-content-container"><!--RIGHT CONTENT-->
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas"></div>
      </div>
    </div><!--RIGHT CONTENT ENDS-->   
  </div><!-- RIGHT COLUMN ENDS -->
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->

</div><!--CLOSE STICKY FOOTER WRAPPER-->
<? $this->load->view('templates/footer')?>
</body>
<script type="text/javascript">  
  $(function() {
    $('#place_name').focus();
    
    
    $('input.place-input').live('keyup.autocomplete', function(){
      $(this).autocomplete({
  			source: function(request,response) {
          $.post(baseUrl+'places/ajax_autocomplete', {query:request.term},
            function(data) {var r = $.parseJSON(data); response( $.map(r, function(item) {
  							return {
  								label: item.name,
  								value: item.name,
  								id: item.id,
  								lat: item.lat,
  								lng: item.lng
  							}
  						}));
  					});
          },
  			minLength: 3,
  			delay: 200,
  			appendTo: '#place',
  			select: function(event,ui) {
  				$('#add-place').click();
  				$(this).siblings('.place_ids').val(ui.item.id);
  				$(this).parent().siblings('.field.dates').css('visibility', 'visible').children('.startdate').focus();
  				$('#trip_name').val(function(i,v) {
  				  return v+' '+ui.item.label.split(',')[0]+',';
  				});
  			}
  		})
		});
  
  
    // dynamic form plugin for multiple places
    $('#place_dates').dynamicForm('#add-place', '#subtract-place', {
      limit: 5,
      afterClone: function(clone) {
        clone.find('input').val('');
        clone.find('.dates').css('visibility', 'hidden');
        // TODO: why doesn't this work?
        clone.find('.place-input').focus();
      }
    });
    
    // jquery form validation plugin
    $('#trip-creation-form').validate({
      rules: {
        startdate: {
          date: true
        },
        enddate: {
          date: true
        }
      },
      messages: {
        trip_name: 'Give your trip a cool name.'
      },
      errorPlacement: function(error, element) {
        error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
      }
    });
    
    
    // clicking create button checks if form is valid
    // if user is logged in, form is submitted
    // if user isn't logged in, login/signup dialogue pops up
    $('#create-submit').click(function() {
      if ($('#trip-creation-form').valid()) {
        var loggedin = loginSignup.getStatus();
        if (loggedin) {
          $('#trip-creation-form').submit();
        } else {
          loginSignup.showDialog('create trip');
        }
      }
      return false;
    });
    
    
    // datepicker jquery plugin
    $('.startdate').live('focus', function() {
      $(this).datepicker();
    });
    $('.enddate').live('focus', function() {
      $(this).datepicker();
    });
    //$('#deadline').datepicker(); 
  });
</script>
</html>