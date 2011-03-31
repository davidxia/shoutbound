<?
$header_args = array(
    'title' => 'Shoutbound',
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
  var baseUrl = "<?=site_url()?>";
</script>

<style type="text/css">
#trip-creation-form {
  margin-top: 20px;
  margin-left:30px;
  margin-right: 235px;
  padding:20px 10px 10px 20px;
  border-radius:5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  color:black;
  font-size: 12px;
  border: 1px solid black;
  background-color:#FAFAFA;
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
	color:navy;
	font-size:14px;
}
.clear {
  clear: both;
}
label.error {
  color: red;
  vertical-align: top;
  font-size: 12px;
}
#create-button {
  color:white;
  height:40px;
  width: 125px;
  line-height:40px;
  text-align:center;
  font-weight:bold;
  font-size:14px;
  text-decoration:none;
  background: #0095cd;
  background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
  background: -moz-linear-gradient(top,  #00adee,  #0078a5);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
  border: solid 1px #0076a3;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0;
  margin-left:248px;
}
#create-button:hover {
  background: #007ead;
  background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
  background: -moz-linear-gradient(top,  #0095cc,  #00678e);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
#create-button:active {
  color: #80bed6;
  background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
  background: -moz-linear-gradient(top,  #0078a5,  #00adee);
  filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}
</style>
</head>


<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
    <div id="div-to-popup" style="background-color:white; display:none;"></div>
		  
        <!-- TRIP CREATION FORM -->
        <form id="trip-creation-form" action="confirm_create" method="post" style="position:relative;">
        
        
          <!-- PLACE DATES FIELD -->
          <fieldset style="border-width:0; border-color:transparent; position:relative; margin-bottom:15px; border-bottom:1px solid #AAA; padding-bottom:20px;">
            <div style="display:inline-block; margin-bottom:5px; color:navy; font-size:14px;">DESTINATION(S)</div>
            <div id="dates-header" style="display:inline-block; visibility:hidden; color:navy; font-size:14px; margin-left:300px; margin-bottom:5px;">DATES (optional)</div>
            <div id="destinations_dates" style="position:relative;">
            <a id="add-destination" href="" style="position:absolute; top:35px; left:2px;">+ Add destination</a><a id="subtract-destination" href="" style="position:absolute; top:5px; left:-15px; font-size:16px;">[-]</a>
              <div class="field destination" style="margin-bottom:10px; margin-right:8px; position:relative; display:inline-block;">
                <span class="label-and-errors">
                  <label for="address0"></label>
                  <span class="error-message" style="position:absolute; top:-18px; left:120px;"></span>
                </span>
                <input type="text" id="address" class="destination-input" name="address" style="width:360px;" autocomplete=off
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
              
              <div class="field dates" style="display:inline-block;visibility:hidden;">
                <span class="label-and-errors">
                  <span class="error-message"></span>
                  <div class="clear"></div>
                </span>
                <label for="startdate">from</label> <input id="startdate" class="startdate" name="startdate" type="text" size="10"/> <label for="enddate">to</label> <input id="enddate" class="enddate" name="enddate" type="text" size="10" />
              </div>
            </div>
  
          </fieldset><!-- PLACE DATES FIELD ENDS -->
          
  
  
          <!-- SUMMARY FIELD -->
          <fieldset id="summary-field" style="border-width:0; border-color:transparent;">
            <div class="field trip_name">
              <span class="label-and-errors">
                <label for="trip_name">TRIP NAME</label>
                <span class="error-message"></span>
                <div class="clear"></div>
              </span>
              <input id="trip_name" name="trip_name" class="required" type="text" style="width:360px; margin-top:5px; margin-bottom:10px;" />
            </div>
             <div class="field" style="margin-top:10px; border-bottom:1px solid #AAA; padding-bottom:10px;">
              <span class="label-and-errors">
                <label for="description">DESCRIBE YOUR TRIP (optional)<span id="chars-left" style="margin-left:50px; color:gray;">140 characters left</span></label>
                <span class="error-message"></span>
                <div class="clear"></div>
              </span>
              <textarea id="description" name="description" style="width:360px; height:56px; font-size:14px; margin-top:5px;"></textarea>
            </div>
          </fieldset><!-- SUMMARY  FIELD ENDS -->

          <!-- PLANNERS ADVISORS FIELD -->
          <!--<fieldset style="border-width:0; border-color:transparent;">
            <div style="border-bottom:1px solid #AAA;">
              <div class="field" style="margin-top: 10px; display:inline-block;">
	              <span class="label-and-errors">
	                <label for="invites">INVITE OTHERS (emails, separated by comma)</label>
	                <span class="error-message"></span>
	                <div class="clear"></div>
	              </span>
	              <input  id="invites" name="invites" type="text" style="width:360px; margin-top:5px;"/>
              </div>
	            <div class="field" style="margin-left:40px; margin-top: 10px; display:inline-block">
	              <span class="label-and-errors">
	                <label for="deadline">DEADLINE (optional)</label>
	                <span class="error-message"></span>
	                <div class="clear"></div>
	              </span>
	              <input id="deadline" name="deadline" type="text" size="10" style="margin-top:5px; margin-bottom:10px;"/>
              </div>

              <div class="field" style="margin-top: 10px; display:inline-block;">
	              <span class="label-and-errors">
	                <label for="advisors">ASK FOR SUGGESTIONS (emails, separated by comma)</label>
	                <span class="error-message"></span>
	                <div class="clear"></div>
	              </span>
	              <input  id="advisors" name="advisors" type="text" style="width:360px; margin-top:5px;"/>
              </div>

              <br/><br/>
              <label for="private" style="color:navy; font-size:14px;">PRIVATE</label>
              <input type="checkbox" name="private" id="private" value="1"/>
            </div>

          </fieldset>--><!-- PLANNERS ADVISORS FIELD ENDS -->
          
  
  
          <!-- INTERESTS FIELD -->
          <!--
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
  
          </fieldset>-->
          <!-- INTERESTS FIELD ENDS -->
  
          <div style="margin-top:10px;">
            <button id="create-button" type="submit">Create</button>
          </div>
          <div style="clear:both;"></div>
        </form><!-- TRIP CREATION FORM ENDS -->
      </div><!-- CONTENT ENDS -->
    </div><!-- WRAPPER ENDS -->
    
    
    <?=$this->load->view('footer')?>

	</body>
</html>

<script type="text/javascript">
  
  function showLoginSignupDialog() {
    $.ajax({
      url: '<?=site_url('users/login_signup')?>',
      success: function(response) {
        var r = $.parseJSON(response);
        $('#div-to-popup').empty();
        $('#div-to-popup').append(r.data);
        $('#div-to-popup').bPopup();
      }
    });
  }
  
  
  function loginSignupSuccess() {
    $('#trip-creation-form').submit();
  }
  
  
  $(document).ready(function() {
    // dates for 1st destination appear if it's filled in
    if ($('#lat').val() != '') {
      //console.log($('#lat').val());
      $('#dates-header').css('visibility', 'visible');
      $('.dates').css('visibility', 'visible');
    }
  
  
    // dynamic form plugin for multiple destinations
    $('#destinations_dates').dynamicForm('#add-destination', '#subtract-destination', {
      limit: 5,
      afterClone: function(clone) {
        clone.find('input').val('');
        clone.find('.dates').css('visibility', 'hidden');
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
        },
        description: {
          maxlength: 140
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
    $('#create-button').click(function() {
      if ($('#trip-creation-form').valid()) {
        $.ajax({
          url: baseUrl+'users/ajax_get_logged_in_status',
          success: function(r) {
            var r = $.parseJSON(r);
            if (r.loggedin) {
              $('#trip-creation-form').submit();
            } else {
              showLoginSignupDialog();
            }
          }
        });
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
    
    
    $('#description').keyup(function() {
      $('#chars-left').html(140 - $(this).val().length+' characters left');
    });
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
      if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40) {
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
                	html[0] = '<div id="auto-loc-list" style="position:absolute; left:22px; background:white; opacity:0.9;">';
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
    var li = $('<li style="padding-left:10px;"></li>');
    li.html('<a href="#" style="text-decoration:none; line-height:30px; padding-top:5px; color:black;">'+resultItem.formatted_address+'</a>');
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
