<?
$header_args = array(
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.10.custom.css',
    ),
    'js_paths'=>array(
        'js/jquery/validate.min.js',
        'js/jquery/jquery-ui-1.8.10.custom.min.js'
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css">
  .progress-bar {
    width: 240px;
    height: 48px;
    cursor: pointer;
  }
  #trip-creation-form {
    padding-top: 30px;
  }
  .next-button, .create-button {
    border: 1px solid black;
    margin-top: 40px;
    margin-right: 20px;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  .next-button:hover, .back-button:hover, .create-button:hover {
    background: url(/david/static/images/blueButton.png) repeat-x 0 -40px;
  }
  .next-button:active, .back-button:active, .create-button:active {
    background: url(/david/static/images/blueButton.png) repeat-x 0 -80px;
  }
  .back-button {
    display: none;
    border: 1px solid black;
    margin-top: 40px;
    margin-left: 20px;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  .next-button a, .back-button a, .create-button a {
    color: white;
    text-decoration: none;
  }
/*
  #summary-invites-field, #interests-field {
    display: none;
  }
*/
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
    float: left;
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

	<body>
    <div id="wrapper" style="margin: 0 auto; width:960px;">
      <?=$this->load->view('header')?>

      <div id="container" style="overflow:hidden;">
        
        
        <!-- MAIN -->
        <div id="main" style="min-height:500px;">
          <!-- TRIP CREATION FORM -->
          <form id="trip-creation-form" action="confirm_create" method="post" style="width:800px;">
          
          
            <!-- PLACE DATES FIELD -->
            <fieldset id="place-dates-field" style="border-width:0; border-color:transparent;">
              <div class="field destination" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="destination">Destination</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input class="required" id="destination" name="destination" autofocus="autofocus" type="text" style="width:380px;"/>
                <!-- AUTO LOC LIST -->
                <div id="auto-loc-list" style="position:absolute; top:60px; left:0px; background:white; opacity:0.8; width:350px;">
                  <ul id="location-autosuggest"></ul>
                </div><!-- AUTO LOC LIST ENDS -->
              </div>
              
              <div class="field dates" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="">Dates (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                From <input id="startdate" name="startdate" type="text" size="11"/> to <input id="enddate" name="enddate" type="text" size="11" />
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
                <input  id="trip_name" name="trip_name" class="required" type="text" style="width:380px;"/>
              </div>
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="invites">Invite people to join your trip (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input  id="invites" name="invites" type="text" style="width:380px;"/>
              </div>
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="">Give them a deadline to respond by (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input type="text" style="width:380px;"/>
              </div>
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="trip-description">Describe your trip in 140 characters or less (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <textarea  id="trip-description" name="trip-description" style="width:380px; height:56px;"></textarea>
              </div>
            </fieldset><!-- SUMMARY INVITES FIELD ENDS -->
            
            <!-- INTERESTS FIELD -->
            <fieldset id="interests-field" style="border-width:0; border-color:transparent; position:relative;">
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="trip-interests">On my trip, I'm interested in (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <textarea  id="trip-interests" name="trip-interests" style="width:380px; height:56px;"></textarea>
              </div>
              
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  I want suggestions for:
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <table>
                  <tbody>
                    <tr>
                      <td class="checkbox-name"><label for="accommodation">Accommodation</label></td>
                      <td class="padding-right"><input type="checkbox" name="accommodation" id="accommodation" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="local-attractions">Local attractions</label></td>
                      <td class="padding-right"><input type="checkbox" name="local-attractions" id="local-attractions" value="local-attractions" /></td>
                      <td class="checkbox-name"><label for="other">Other</label></td>
                      <td><input type="checkbox" name="other" id="other" value="other" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="restaurants">Restaurants</label></td>
                      <td class="padding-right"><input type="checkbox" name="restaurants" id="restaurants" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="bars-nightlife">Bars/nightlife</label></td>
                      <td class="padding-right"><input type="checkbox" name="bars-nightlife" id="bars-nightlife" value="bars-nightlife" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="landmarks">Landmarks</label></td>
                      <td class="padding-right"><input type="checkbox" name="landmarks" id="landmarks" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="activities-events">Activities/events</label></td>
                      <td class="padding-right"><input type="checkbox" name="activities-events" id="activities-events" value="activities-events" /></td>
                    </tr>
                    <tr>
                      <td class="checkbox-name"><label for="shopping">Shopping</label></td>
                      <td class="padding-right"><input type="checkbox" name="shopping" id="shopping" value="accommodation" /></td>
                      <td class="checkbox-name"><label for="landmarks">Landmarks</label></td>
                      <td class="padding-right"><input type="checkbox" name="landmarks" id="landmarks" value="landmarks" /></td>
                    </tr>
                  </tbody>
                </table>
                <textarea id="other-textbox" style="position:absolute; right:185px; top:150px; width:200px; height:63px; display:none;"></textarea>
              </div>

              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="advisors">Ask specific friends to give you advice for your trip.</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input id="advisors" name="advisors" type="text" size="40" />
              </div>
              
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="">Share this trip on Facebook and Twitter to get more advice.</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input type="text" size="40" />
              </div>


            </fieldset><!-- INTERESTS FIELD ENDS -->
            <input class="submit" type="submit" value="Submit"/>
          </form><!-- TRIP CREATION FORM ENDS -->
          
        </div><!-- MAIN DIV ENDS -->
      </div><!-- CONTAINER ENDS -->
    </div><!-- WRAPPER ENDS -->
	
	</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    
    $('#trip-creation-form').validate({
      messages: {
       destination: 'You need a destination for a trip, silly :p',
       trip_name: 'Give your trip a cool name.'
      },
      errorPlacement: function(error, element) {
        error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
      }
    });
   
    $('div.next-button').click(function() {
      showPart2();
    });
    
    $('#part2-indicator').click(function() {
      showPart2();
    });


    var showPart1 = function() {
      $('#part1-indicator').css('background-color', '#D0D0FF');
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', 'transparent');

      $('div.back-button').fadeOut(300);
      $('div.next-button').unbind().click(function() {
        showPart2();
      });
      $('#part1-indicator').unbind();
      $('#part2-indicator').unbind().click(function() {
        showPart2();
      });
      $('#part3-indicator').unbind().click(function() {
        showPart3();
      });
      
      $('#place-dates-field').show();
      $('#summary-invites-field').hide();
      $('#interests-field').hide();
    };


    var showPart2 = function() {
      $('#part1-indicator').css('background-color', 'transparent');
      $('#part2-indicator').css('background-color', '#D0D0FF');
      $('#part3-indicator').css('background-color', 'transparent');
      
      $('div.back-button').fadeIn(300).click(function() {
        showPart1();
      });
      $('div.next-button').unbind();
      $('div.create-button').unbind().removeClass('create-button').addClass('next-button').html('<a href="#">Next</a>');
      $('div.next-button').click(function() {
        showPart3();
      });
      
      $('#part1-indicator').unbind().click(function() {
        showPart1();
      });
      $('#part2-indicator').unbind();
      $('#part3-indicator').unbind().click(function() {
        showPart3();
      });      
      
      $('#place-dates-field').hide();
      $('#summary-invites-field').show();
      $('#interests-field').hide();
    }
    
    
    var showPart3 = function() {
      $('#part1-indicator').css('background-color', 'transparent');
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', '#D0D0FF');
      
      $('div.back-button').unbind().click(function() {
        showPart2();
      });
      $('div.next-button').unbind().removeClass('next-button').addClass('create-button').html('<a href="#">Create</a>');
      $('div.create-button').click(function() {
        alert('youve created a trip');
      });
      
      
      $('#part1-indicator').unbind().click(function() {
        showPart1();
      });
      $('#part2-indicator').unbind().click(function() {
        showPart2();
      });
      $('#part3-indicator').unbind();
      
      $('#place-dates-field').hide();
      $('#summary-invites-field').hide();
      $('#interests-field').show();
    };
    
    
    $('#other').click(function() {
      $('#other-textbox').toggle();
    });

    // datepicker jquery plugin
    $('#startdate').datepicker();
    $('#enddate').datepicker();    
    
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
    $('#destination').keyup(function() {
      map.delay(map.geocodeLocationQuery, 1000);
    });
  };

  // delay geocoder api for 1 second of keyboard inactivity
  map.delay = (function() {
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();
  
  map.geocodeLocationQuery = function() {
    // new geocoder to convert address/name into latlng co-ords
    var geocoder = new google.maps.Geocoder();
    var query = $('#destination').val().trim();
      
    // geocode request sent after user stops typing for 1 second
    if (query.length > 1) {
      geocoder.geocode({'address': query}, map.returnGeocodeResult);
    } else {
    	$('#location-autosuggest').html('');
    }
  };
  
  
  // this callback function is passed the geocoderResult object
  map.returnGeocodeResult = function(result, status) {
    if (status == google.maps.GeocoderStatus.OK && result[0]) {
    	$('#location-autosuggest').empty();
    	for (var i=0; i<result.length; i++) {
    		map.listResult(result[i]);
    	}
    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
    	$('#location-autosuggest').html('Aw, we couldn\'t find that place.');
    } else {
    	$('#location-autosuggest').html(status);
    }
  };
  
  
  // selectable dropdown list
  map.listResult = function(resultItem) {
    var li = $('<li></li>');
    li.html('<a href="#">'+resultItem.formatted_address+'</a>');
    li.click(function(){
      map.clickGeocodeResult(resultItem);
      return false;
    });
    $('#location-autosuggest').append(li);
  };

  map.clickGeocodeResult = function(resultItem) {
    $('#destination').val(resultItem.formatted_address);
    $('#location-autosuggest').empty();
    
  };

</script>
