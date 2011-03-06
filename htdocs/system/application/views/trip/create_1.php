<?
$header_args = array(
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.10.custom.css',
    ),
    'js_paths'=>array(
        'js/jquery/validate.min.js',
        'js/jquery/jquery-ui-1.8.10.custom.min.js',
        'js/jquery/popup.js',
        'js/jquery/jquery-dynamic-form.js'
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url("")?>";
  var staticUrl = "<?=static_url("")?>";
</script>

<style type="text/css">
  #trip-creation-form {
    margin-top: 20px;
    margin-right: 200px;
    padding:20px 20px 20px 20px;
    border-radius:5px;
    background-color:#e4f1fb;
    color:navy;
    border:1 px solid navy;    
  }
  #main table{
    border-collapse: collapse;
  }
  #main th, td {
    padding: 0 0 15px 0;
  }
  #main th {
    text-align: right;
    font-weight: normal;
    font-size: 16px;
    padding-right: 10px;
    min-width: 200px;
  }
  #interests-box td {
    text-align: right;
  }
  .checkbox-name {
    padding-right: 10px;
  }
  .padding-right {
    padding-right: 40px;
  }
  #other-textbox {
    position: absolute;
  }
  body form div.field {
    
  }
  body form .label-and-errors {
  
  }
  .clear {
    clear: both;
  }
  label.error {
    color: red;
    vertical-align: top;
    font-size: 12px;
  }

</style>
 
 
<?=$this->load->view('core_header_end')?>

	<body style="background:url('http://dev.shoutbound.com/david/images/trip_page_background.png'); background-repeat:repeat-x;">
    <div id="div-to-popup" style="background-color:white; display:none;"></div>
    
		<!-- HEADER -->
    <div class="header" style="background-color:#4483B1; color:white; height:50px; display:block;">
      <div class="wrapper" style="width:960px; margin:0 auto; position:relative;">
        <div class="nav" style="position:absolute; right:0; top:0;">
          <a href="<?=site_url('login')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Login</a>
          <a href="<?=site_url('signup')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Sign Up</a>
        </div>
        <h1 style="position:absolute; left:0; top:0px;">
          <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" alt="Shoutbound" width="81" height="50"/></a>
        </h1>
      </div>
    </div><!-- HEADER ENDS -->


		  
    <!-- CONTENT -->
    <div style="margin: 0 auto; width:960px;" class="content wrapper">
      <!-- TRIP CREATION FORM -->
      <form id="trip-creation-form" action="confirm_create" method="post" style="position:relative;">
      
      
        <!-- PLACE DATES FIELD -->
        <fieldset style="border-width:0; border-color:transparent; position:relative; margin-bottom:30px;">
          <div style="width:412px; display:inline-block; margin-left:10px; margin-bottom:20px;">Destinations</div><div id="dates-header" style="width:298px; display:inline-block; visibility:hidden;">Dates</div>
          <div id="destinations_dates" style="position:relative;">
          <a id="add-destination" href="" style="position:absolute; top:20px; left:-10px;">[+]</a><a id="subtract-destination" href="" style="position:absolute; top:0; left:-10px;">[-]</a>
            <div class="field destination" style="margin-left:10px; margin-bottom:10px; position:relative; display:inline-block;">
              <span class="label-and-errors">
                <label for="address0">1.</label>
                <span class="error-message" style="position:absolute; top:-14px;"></span>
              </span>
              <input type="text" id="address" class="destination-input" name="address" style="width:360px;"/>
              <input type="hidden" id="lat" class="required destination_lat" name="lat"/>
              <input type="hidden" id="lng" class="destination_lng" name="lng"/>
            </div>
            
            <div class="field dates" style="margin-left:10px; display:inline-block; visibility:hidden;">
              <span class="label-and-errors">
                <span class="error-message"></span>
                <div class="clear"></div>
              </span>
              <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10" />
            </div>
          </div>

        </fieldset><!-- PLACE DATES FIELD ENDS -->
        


        <!-- SUMMARY INVITES FIELD -->
        <fieldset id="summary-invites-field" style="border-width:0; border-color:transparent;">
          <div class="field trip_name" style="margin-left:10px;">
            <span class="label-and-errors">
              <label for="trip_name">Trip name</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <input id="trip_name" name="trip_name" class="required" type="text" style="width:380px;" />
          </div>
           <div class="field" style="margin-left:10px; margin-top:10px;">
            <span class="label-and-errors">
              <label for="trip-description">Describe your trip (optional)</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <textarea id="trip-description" name="trip-description" style="width:380px; height:56px; font-size:14px;"></textarea>
          </div>
          <div class="field" style="margin-left:10px; margin-top: 10px; display:inline-block">
            <span class="label-and-errors">
              <label for="invites">Invite people to join your trip (optional)</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <input  id="invites" name="invites" type="text" style="width:380px;"/>
          </div>
          <div class="field" style="margin-left:40px; margin-top: 10px; display:inline-block">
            <span class="label-and-errors">
              <label for="">Deadline for response (optional)</label>
              <span class="error-message"></span>
              <div class="clear"></div>
            </span>
            <input id="deadline" name="deadline" type="text" size="10"/>
          </div>
        </fieldset><!-- SUMMARY INVITES FIELD ENDS -->
        
        <input class="submit" type="submit" value="" style="border:0; cursor:pointer; background:url('http://dev.shoutbound.com/david/images/create-button.png'); background-repeat:no-repeat; height:55px; width:175px; position:relative; left:500px; top:5px;" />
      </form><!-- TRIP CREATION FORM ENDS -->
      
    </div><!-- CONTENT ENDS -->
	
	</body>
</html>

<script type="text/javascript">
  
  function showLoginDialog() {
    $.ajax({
      url: baseUrl+'users/login_signup',
      success: function(response) {
        var r = $.parseJSON(response);
        $('#div-to-popup').empty();
        $('#div-to-popup').append(r['data']);
        $('#div-to-popup').bPopup();
      }
    });
  }
  
  
  $(document).ready(function() {
    $('#destinations_dates').dynamicForm('#add-destination', '#subtract-destination', {limit:5});
    
    /*
    // add another destination and date inputs
    $('#add-destination').click(function() {
      $(this).hide();
      
      var id = $(this).prev().prev().children('input.destination-input').attr('id');
      var n = parseInt(id.replace('destinations_address_', ''))+1;
      console.log(n);
      var html = [];
      html[0] = '<div class="field destination" style="margin-left:10px; margin-bottom:10px; position:relative; float:left;">';
      html[1] = '<span class="label-and-errors">';
      html[2] = '<label for="destinations_address_'+n+'">'+n+'.</label> ';
      html[3] = '<span class="error-message" style="position:absolute; top:-7px;"></span>';
      html[4] = '</span>';
      html[5] = '<input type="text" id="destinations_address_'+n+'" class="destination-input" name="destinations['+n+'][address]" autofocus="autofocus" autocomplete="off" style="width:360px;"/>';
      html[6] = '<input type="hidden" id="destinations_lat_'+n+'" class="destination_lat" name="destinations['+n+'][lat]"/>';
      html[7] = '<input type="hidden" id="destinations_lng_'+n+'" class="destination_lng" name="destinations['+n+'][lng]"/>';
      html[8] = '</div>';
      html[9] = '<div class="field dates" id="dates_'+n+'" style="margin-left:10px; float:left; visibility:hidden;">';
      html[10] = '<span class="label-and-errors">';
      html[11] = '<span class="error-message"></span>';
      html[12] = '<div class="clear"></div>';
      html[13] = '</span>';
      html[14] = '<label for="startdate_'+n+'">from</label> ';
      html[15] = '<input id="startdate_'+n+'" class="startdate" name="destinations['+n+'][startdate]" type="text" size="10"/>';
      html[16] = ' <label for="enddate_'+n+'">to</label> ';
      html[17] = '<input id="enddate_'+n+'" class="enddate" name="destinations['+n+'][enddate]" type="text" size="10" />';
      html[18] = '</div>';
      html = html.join('');

      $(html).insertBefore('#add-destination');
      return false;
    });
    */
    
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
    $('input.submit').click(function() {
      if ($('#trip-creation-form').valid()) {
        $.ajax({
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(response) {
            var r = $.parseJSON(response);
            if (r.loggedin) {
              $('#trip-creation-form').submit();
            } else {
              showLoginDialog();
            }
          }
        });
      }
      return false;
    });
        
    
    $('#other').click(function() {
      $('#other-textbox').toggle();
    });

    // datepicker jquery plugin
    $('.startdate').live('focus', function() {
      $(this).datepicker();
    });
    $('.enddate').live('focus', function() {
      $(this).datepicker();
    });
    $('#deadline').datepicker(); 
  });
  
  ///////////////////////////////////////
  // load geocoder for destination field
  var map = {};
  
  $(document).ready(function() {
    map.loadGoogleMapScript();
  });

  map.loadGoogleMapScript = function() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'http://maps.google.com/maps/api/js?sensor=false&callback=map.loadGoogleMap';
    document.body.appendChild(script);
  };
  
  map.loadGoogleMap = function() {
    // bind onkeyup event to location-search-box
    $('input.destination-input').live('keyup', function() {
      var domInput = this;
      map.delay(function() {
        // new geocoder to convert address/name into latlng co-ords
        var geocoder = new google.maps.Geocoder();
        var query = $(domInput).val().trim();
          
        // geocode request sent after user stops typing for 1 second
        if (query.length > 1) {
          geocoder.geocode({'address': query}, function(result, status) {
            if (status == google.maps.GeocoderStatus.OK && result[0]) {
              if ($(domInput).next().attr('id') != 'auto-loc-list') {
              	var html = [];
              	html[0] = '<div id="auto-loc-list" style="padding-left:20px; background:white; opacity:0.9;">';
              	html[1] = '<ul id="location-autosuggest"></ul>';
              	html[2] = '</div>';
              	html = html.join('');
              	$(html).insertAfter($(domInput));
              } else {
                $('#location-autosuggest').empty();
              }
            	
            	for (var i=0; i<result.length; i++) {
            		map.listResult(result[i], domInput);
            	}
            } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
            	$('#location-autosuggest').html('Aw, we couldn\'t find that place.');
            } else {
            	$('#location-autosuggest').html(status);
            }
          });
        } else {
        	$('#location-autosuggest').html('');
        }
      }, 300);
    });
  };

  // delay geocoder api for 1 second of keyboard inactivity
  map.delay = (function() {
    var timer = 0;
    return function(callback, ms) {
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();
    
  
  // selectable dropdown list
  map.listResult = function(resultItem, domInput) {
    var li = $('<li></li>');
    li.html('<a href="#" style="background-color:white; text-decoration: none; line-height:40px; font:helvetica neue; font-size: 16px; padding-top: 5px; border-bottom: 1px solid gray; color:navy;">'+resultItem.formatted_address+'</a>');
    li.click(function(){
      map.clickGeocodeResult(resultItem, domInput);
      return false;
    });
    $('#location-autosuggest').append(li);
  };

  map.clickGeocodeResult = function(resultItem, domInput) {
    $(domInput).val(resultItem.formatted_address);
    $('#auto-loc-list').remove();
    $(domInput).siblings('input.destination_lat').val(resultItem.geometry.location.lat());
    $(domInput).siblings('input.destination_lng').val(resultItem.geometry.location.lng());
    $(domInput).parents('div.destination').next().css('visibility', 'visible');
    $('#dates-header').css('visibility', 'visible');
  };


</script>
