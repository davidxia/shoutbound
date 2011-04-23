<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
    ),
    'js_paths'=>array(
        'js/user/loginSignup.js',
        'js/jquery/validate.min.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/popup.js',
        'js/jquery/jquery-dynamic-form.js'
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>

<style type="text/css">
#trip-creation-form {
  padding: 20px;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border: 1px solid black;
}
#trip-creation-form fieldset {
  margin-bottom:20px;
  border-bottom:1px solid #AAA;
  padding-bottom:20px;
}
#location-autosuggest .selected, #location-autosuggest li:hover {
  font-weight:bold;
  background-color: #E0E0FF;
  cursor:pointer;
}
</style>
</head>


<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
    <div id="div-to-popup" style="background-color:white; display:none;"></div>
		  
        <!-- TRIP CREATION FORM -->
        <form id="trip-creation-form" action="confirm_create" method="post" style="position:relative; width:576px; margin:0 auto;">
        
        
          <!-- PLACE DATES FIELD -->
          <fieldset style="position:relative;">
            <div style="display:inline-block; margin-bottom:5px;">Destinations</div>
            <div id="dates-header" style="display:inline-block; visibility:hidden; margin-left:230px; margin-bottom:5px;">Dates (optional)</div>
            <div id="destinations_dates" style="position:relative; margin-bottom:10px;">
              <a id="add-destination" href="" style="position:absolute; top:15px; left:-15px; font-size:13px;">[+]</a><a id="subtract-destination" href="" style="position:absolute; top:-2px; left:-15px;">[-]</a>
              <div class="field destination" style="margin-bottom:10px; float:left; position:relative; width:312px;">
                <span class="label-and-errors">
                  <label for="address0"></label>
                  <span class="error-message" style="float:right;"></span>
                </span>
                <input type="text" id="address" class="destination-input" name="address" style="width:300px;" autocomplete=off
        			    <? if ($destination):?>
        			      <? echo 'value="'.$destination.'"'?>
                  <? endif;?>
                />
                <input type="hidden" id="lat" class="required destination_lat" name="lat"
        			    <? if ($destination_lat):?>
        			      <? echo 'value="'.$destination_lat.'"'?>
                  <? endif;?>
                />
                <input type="hidden" id="lng" class="destination_lng" name="lng"
        			    <? if ($destination_lng):?>
        			      <? echo 'value="'.$destination_lng.'"'?>
                  <? endif;?>
                />
              </div>
              
              <div class="field dates" style="width:251px; margin-left:325px; visibility:hidden;">
                <span class="label-and-errors">
                  <span class="error-message" style="float:right;"></span>
                  <div class="clear"></div>
                </span>
                <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10" />
              </div>
            </div>
          </fieldset><!-- PLACE DATES FIELD ENDS -->
          
  
  
          <!-- SUMMARY FIELD -->
          <fieldset id="summary-field" style="width:576px;">
            <div class="field trip_name">
              <span class="label-and-errors">
                <label for="trip_name">Trip name</label>
                <span class="error-message" style="float:right;"></span>
                <div class="clear"></div>
              </span>
              <input id="trip_name" name="trip_name" class="required" type="text" style="width:564px; margin-top:5px; margin-bottom:10px;" />
            </div>
             <div class="field" style="margin-top:10px; padding-bottom:10px;">
              <span class="label-and-errors">
                <label for="description">Trip description</label>
                <span class="error-message" style="float:right;"></span>
                <div class="clear"></div>
              </span>
              <textarea id="description" name="description" style="width:564px; height:56px; font-size:14px; margin-top:5px; resize:none;"></textarea>
            </div>
          </fieldset><!-- SUMMARY  FIELD ENDS -->

  
          <div style="margin-top:10px;">
            <button id="create-submit" class="blue-button" type="submit">Create</button>
          </div>
        </form><!-- TRIP CREATION FORM ENDS -->
      </div><!-- CONTENT ENDS -->
    </div><!-- WRAPPER ENDS -->
    
    
    <? $this->load->view('footer')?>

	</body>
</html>

<script type="text/javascript">  
  $(document).ready(function() {
    $('#address').focus();
  
    // dates for 1st destination appear if it's filled in
    if ($('#lat').val() != '') {
      $('#dates-header').css('visibility', 'visible');
      $('.dates').css('visibility', 'visible');
    }
  
  
    // dynamic form plugin for multiple destinations
    $('#destinations_dates').dynamicForm('#add-destination', '#subtract-destination', {
      limit: 5,
      afterClone: function(clone) {
        clone.find('input').val('');
        clone.find('.dates').css('visibility', 'hidden');
        // TODO: why doesn't this work?
        clone.find('.destination-input').focus();
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
    $('#deadline').datepicker(); 
  });
  

  // allows user to use up/down arrows to select from autosuggest list
  $('.destination-input').keyup(function(e) {
    var destination = $(this);
    var keyCode = e.keyCode || e.which,
        arrow = {up: 38, down: 40};
      
    /*key navigation through elements*/
    if (keyCode == arrow.up || keyCode == arrow.down) {
      var results = $('#location-autosuggest li');
  
      var current = results.filter('.selected'),
          next;
      
      switch (keyCode) {
        case arrow.up:
          next = current.prev();
          break;
        case arrow.down:
          if (!results.hasClass('selected')) {
            results.first().addClass('selected');
          }
          next = current.next();
          break;
      }
  
      //only check next element if up and down key pressed
      if (next.is('li')) {
        current.removeClass('selected');
        next.addClass('selected');
      }
  
      //update text in searchbar
      if (results.hasClass('selected')) {
        destination.val($('.selected').text());
        destination.siblings('.destination_lat').val($('.selected').children('a').attr('lat'));
        destination.siblings('.destination_lng').val($('.selected').children('a').attr('lng'));
      }
  
      //set cursor position
      if (keyCode === arrow.up) {
        return false;
      }

      return;
    }
  });


  $('.destination-input').bind('keydown keypress', function(e) {
    var keyCode = e.keyCode || e.which,
      arrow = {up: 38, enter: 13};
    
    if (keyCode == arrow.up || keyCode == arrow.enter) {
      e.preventDefault();
    }
    if (keyCode == arrow.enter) {
      $('#location-autosuggest').remove();
      var dates = $(this).parent().next();
      dates.css('visibility', 'visible');
      dates.children('.startdate').focus();
    }    
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
    $('input.destination-input').live('keyup', function(e) {
      var keyCode = e.keyCode || e.which;
      // ignore arrow keys
      if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40 && keyCode!==13) {
        var domInput = this;
        map.delay(function() {
          // new geocoder to convert address/name into latlng co-ords
          var geocoder = new google.maps.Geocoder();
          var query = $(domInput).val().trim();
            
          // geocode request sent after user stops typing for 1 second
          if (query.length > 1) {
            geocoder.geocode({'address': query}, function(result, status) {
              if (status == google.maps.GeocoderStatus.OK && result[0]) {
                if ($(domInput).next().attr('id') != 'location-autosuggest') {
                	var html = [];
                	html[1] = '<ul id="location-autosuggest" style="position:absolute; background:white; width:310px; border:1px solid #8F8F8F; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index:10;"></ul>';
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
        }, 200);
      }
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
    var li = $('<li style="padding:0 10px 0 7px;"></li>');
    li.html('<a href="#" style="text-decoration:none; line-height:30px; color:black;" lat="'+resultItem.geometry.location.lat()+'" lng="'+resultItem.geometry.location.lng()+'">'+resultItem.formatted_address+'</a>');
    li.click(function(){
      map.clickGeocodeResult(resultItem, domInput);
      return false;
    });
    $('#location-autosuggest').append(li);
  };

  map.clickGeocodeResult = function(resultItem, domInput) {
    $(domInput).val(resultItem.formatted_address);
    $('#location-autosuggest').remove();
    $(domInput).siblings('input.destination_lat').val(resultItem.geometry.location.lat());
    $(domInput).siblings('input.destination_lng').val(resultItem.geometry.location.lng());
    $(domInput).parents('div.destination').next().css('visibility', 'visible');
    $('#dates-header').css('visibility', 'visible');
  };
</script>