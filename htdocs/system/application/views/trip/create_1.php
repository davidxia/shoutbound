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
    margin-top:15px;
    margin-left:90px;
    margin-right:10px;
    padding-top:30px;
    padding-left:30px;
    padding-right:30px;
    padding-bottom:30px;
    margin-bottom:20px;
    border-radius:20px;
    background-color:#e4f1fb;
    color:navy;
    font-size:18px;
    font-weight:bold;
    font-family:helvetica neue;
    border:1 px solid navy;
    box-shadow:  0 0 8px 8px gray; 
    -webkit-box-shadow:  0 0 8px 8px gray;
    
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

	<body style="background:url('http://dev.shoutbound.com/david/images/trip_page_background.png'); background-repeat:repeat-x;">
		<div id="fb-root"></div>
		<script>
		    window.fbAsyncInit = function() {
		        FB.init({appId: '136139119767617', status: true, cookie: true, xfbml: true});
		    };
		    (function() {
		        var e = document.createElement('script'); e.async = true;
		        e.src = document.location.protocol +
		            '//connect.facebook.net/en_US/all.js';
		        document.getElementById('fb-root').appendChild(e);
		    }());
		</script>

    <div id="wrapper" style="margin: 0 auto; width:960px;">
     	<?//=$this->load->view('header')?>

      <div id="container" style="overflow:hidden; width:960px">
        
		<!-- HEADER -->
		<div id="header" style="height:60px; padding: 10px 0 10px;">
		  <div id="logo" style="float:left;">
		    <a class="home" href="<?=site_url('home')?>" style="font-size:26px; display:block; height:60px; width:95px; background:url('<?=site_url('images/logo_header.png')?>'); text-indent:-9999px;">Shoutbound</a>
		  </div>
		  
		  <div style="background-color:#4483B1; border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; float:right; width:830px; border: 1px solid #8BB5C8;">
		  	<!--<div style="float:left; margin-left:200px; padding-top:5px;">
		    	<a href="<?=site_url('trips/create')?>" style="font-size:26px;"><img src="<?=site_url('images/create_trip_button.png')?>" /></a>
		    </div>-->
		    
		    <ul id="navigation" style="float:right; line-height:60px;">
		      <li style="float:right; margin-right:10px;"><a href="<?=site_url('users/logout')?>" style="color:white; text-decoration:none;">Logout</a></li>
		      <li style="float:right; margin-right:10px;"><a href="<?=site_url('profile/settings')?>" style="color:white; text-decoration:none;">Settings</a></li>
		      <li style="float:right; margin-right:10px;"><a href="<?=site_url('home')?>" style="color:white; text-decoration:none;">Home</a></li>
		    </ul>
		  </div>
		</div><!-- HEADER ENDS -->
		  
        <!-- MAIN -->
        <div id="main" style="min-height:500px;">
          <!-- TRIP CREATION FORM -->
          <form id="trip-creation-form" action="confirm_create" method="post" style="width:800px;">
          
          
            <!-- PLACE DATES FIELD -->
            <fieldset id="place-dates-field" style="border-width:0; border-color:transparent;">
              <div class="field destination" style="margin-left:10px; margin-bottom:10px; position:relative;">
                <span class="label-and-errors">
                  <label for="destination">Destination</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input type="text" class="required" id="destination" name="destination" autofocus="autofocus" style="width:380px;"
                  <? if ($destination):?>
                    <?='value="'.$destination.'"'?>
                  <? endif;?>
                />
                <input type="hidden" id="destination-lat" name="destination-lat" 
                  <? if ($destination_lat):?>
                    <?='value="'.$destination_lat.'"'?>
                  <? endif;?>
                />
                <input type="hidden" id="destination-lng" name="destination-lng" 
                  <? if ($destination_lng):?>
                    <?='value="'.$destination_lng.'"'?>
                  <? endif;?>
                />
                <!-- AUTO LOC LIST -->
                <div id="auto-loc-list" style="position:absolute; top:57px; background:#EAEAEA; opacity:0.9; width:350px;">
                  <ul id="location-autosuggest"></ul>
                </div><!-- AUTO LOC LIST ENDS -->
              </div>
              
              <div class="field dates" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="">Dates (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                From <input id="startdate" name="startdate" type="text" size="10"/> to <input id="enddate" name="enddate" type="text" size="10" />
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
                <input id="trip_name" name="trip_name" class="required" type="text" style="width:380px;"/>
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
            
            <!-- INTERESTS FIELD -->
            <fieldset id="interests-field" style="border-width:0; border-color:transparent; position:relative;">
              <div class="field" style="margin-left:10px; margin-top: 10px;">
                <span class="label-and-errors">
                  <label for="trip-interests">On my trip, I'm interested in (optional)</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <textarea  id="trip-interests" name="trip-interests" style="width:380px; height:56px;"></textarea>
              </div>
              
              <div class="field" style="margin-left:10px; margin-top: 10px; margin-bottom:10px;">
                <span class="label-and-errors">
                  I want suggestions for:
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <table style="margin-top:10px; margin-left:20px;">
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
                      <td class="checkbox-name"><label for="landmarks">Natural features</label></td>
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
                  <label for="advisors">Ask friends and family for advice</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input id="advisors" name="advisors" type="text" size="40" />
              </div>
              
              <div class="field" style="margin-left:10px;">
                <span class="label-and-errors">
                  <label for="">Share this trip on Facebook and Twitter</label>
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <input type="text" size="40" />
              </div>


            </fieldset><!-- INTERESTS FIELD ENDS -->
            <? if ($user):?>
              <input class="submit" type="submit" value="" style="border:0; cursor:pointer; background:url('http://dev.shoutbound.com/david/images/create-button.png'); background-repeat:no-repeat; height:55px; width:175px; position:relative; left:500px; top:5px; "/>
            <? else:?>
              <a href="#" id="fb_login_button"><div style="cursor:pointer; background:url('http://dev.shoutbound.com/david/images/create-button.png'); background-repeat:no-repeat; height:55px; width:175px; position:relative; left:500px; top:5px;"></div></a>
            <? endif;?>
          </form><!-- TRIP CREATION FORM ENDS -->
          
        </div><!-- MAIN DIV ENDS -->
      </div><!-- CONTAINER ENDS -->
    </div><!-- WRAPPER ENDS -->
	
	</body>
</html>

<script type="text/javascript">
	function shoutboundLogin() {        
    $.ajax({
      url: "<?=site_url('users/ajax_login')?>",
      type: 'POST',
      dataType: 'json',
      success: function(data) {        
        if (data['success']) {
          $('form#trip-creation-form').submit();
        } else {
          alert(data['message']);
        }
      }
    });
	}
		

  $(document).ready(function() {

    $('#fb_login_button').click(function() {
      FB.login(function(response) {
        if (response.session) {
          shoutboundLogin();
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
    
    $('#destination-input').focus(function() {
      if ($(this).val() == 'Where do you want to go?') {
        $(this).val('');
      }
    }).blur(function() {
      if ($.trim($(this).val()) == '') {
        $(this).val('Where do you want to go?');
      }
    });
    
    
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
    $('#destination').keyup(function() {
      map.delay(map.geocodeLocationQuery, 500);
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
    $('#destination-lat').val(resultItem.geometry.location.lat());
    $('#destination-lng').val(resultItem.geometry.location.lng());
  };


</script>