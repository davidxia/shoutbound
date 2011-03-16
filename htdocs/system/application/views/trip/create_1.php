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
  var baseUrl = "<?=site_url("")?>";
  var staticUrl = "<?=static_url("")?>";
</script>

<style type="text/css">
#trip-creation-form {
  margin-top: 20px;
  margin-right: 200px;
  padding:20px 20px 20px 20px;
  border-radius:5px;
  color:navy;
  border:1px solid #AAA;
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
#create-button {
  color:white;
  height:40px;
  width: 154px;
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
  margin:0;
  float: right;
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
 
 
<?=$this->load->view('core_header_end')?>

	<body style="background-color:#1B272C; min-width:960px;">
    <div id="div-to-popup" style="background-color:white; display:none;"></div>
    
    <? $this->load->view('header')?>

		  
    <!-- WRAPPER -->
    <div class="wrapper" style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">
      <!-- CONTENT -->
      <div class="content" style="margin:0 auto; padding-top:30px; width:960px; padding-bottom:80px;">
        <!-- TRIP CREATION FORM -->
        <form id="trip-creation-form" action="confirm_create" method="post" style="position:relative;">
        
        
          <!-- PLACE DATES FIELD -->
          <fieldset style="border-width:0; border-color:transparent; position:relative; margin-bottom:30px;">
            <div style="width:412px; display:inline-block; margin-left:10px; margin-bottom:20px;">Destinations</div><div id="dates-header" style="width:298px; display:inline-block; visibility:hidden;">Dates</div>
            <div id="destinations_dates" style="position:relative;">
            <a id="add-destination" href="" style="position:absolute; top:20px; left:-10px;"><img src="<?=site_url('images/plus_icon.jpg')?>" height="20" width="20"/></a><a id="subtract-destination" href="" style="position:absolute; top:0; left:-10px;"><img src="<?=site_url('images/minus_icon.jpg')?>" height="20" width="20"/></a>
              <div class="field destination" style="margin-left:10px; margin-bottom:10px; position:relative; display:inline-block;">
                <span class="label-and-errors">
                  <label for="address0">1.</label>
                  <span class="error-message" style="position:absolute; top:-14px;"></span>
                </span>
                <input type="text" id="address" class="destination-input" name="address" style="width:360px;"
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
              
              <div class="field dates" style="margin-left:10px; display:inline-block;
                <? if ( ! isset($destination)):?>
                  visibility:hidden;
                <? endif;?>
              ">
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
                <label for="description">Describe your trip <span id="chars-left">140 characters left</span></label>
                <span class="error-message"></span>
                <div class="clear"></div>
              </span>
              <textarea id="description" name="description" style="width:380px; height:56px; font-size:14px;"></textarea>
            </div>
            <div class="field" style="margin-left:10px; margin-top: 10px; display:inline-block">
              <span class="label-and-errors">
                <label for="invites">Invite people to join your trip (emails)</label>
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
          
          <label for="private">Private</label>
          <input type="checkbox" name="private" id="private" value="1"/>
  
  
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
  
          <div>
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
      url: baseUrl+'users/login_signup',
      success: function(response) {
        var r = $.parseJSON(response);
        $('#div-to-popup').empty();
        $('#div-to-popup').append(r.data);
        $('#div-to-popup').bPopup();
      }
    });
  }
  
  
  $(document).ready(function() {
  
    // dynamic form plugin for multiple destinations
    $('#destinations_dates').dynamicForm('#add-destination', '#subtract-destination', {
      limit: 5,
      afterClone: function(clone) {
        clone.find('input').val('');       
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
          success: function(response) {
            var r = $.parseJSON(response);
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
      }, 200);
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
