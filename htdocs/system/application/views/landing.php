<?
$header_args = array(
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>
</head>

<body style="background-color: #E0E0E0; margin:0 0 0 0">

	<div class="wrapper" style="margin: 0 auto; width:960px; background: white url('<?=site_url('images/hills_and_logo.png')?>') no-repeat 0 0;">
	
  	<!-- MAIN -->		
  	<div class="content" style="height:761px; position:relative;">
  	  <div style="padding-top:20px;">
    		<a href="<?=site_url('login')?>" style="display:block; background:transparent url(<?=site_url('images/login.png')?>) no-repeat 0 0; height:45px; width:120px; text-indent:-10000px; float:right; margin-right:20px;">Login</a>
    	  <a href="<?=site_url('signup')?>" style="display:block; background:transparent url(<?=site_url('images/signup.png')?>) no-repeat 0 0; height:45px; width:120px; text-indent:-10000px; float:right; margin-right:20px;">Sign up</a>
    	  <div style="clear:both;"></div>
  	  </div>
  		
  		
  		<div style="background:#1b272c; margin-top:100px; padding:20px;">
    		<div style="float:right; line-height:90px;">
    		  <form id="destination" action="trips/create" method="post" style="position:relative;">
    			  <input type="text" id="destination-input" name="destination" autocomplete="off" style="border-radius:5px; -moz-border-radius:5px;
  -webkit-border-radius:5px; height:69px; width:320px; padding:0 100px 0 15px; font-size:22px; font-weight: bold; color:#000080;" value="Where do you want to go?"/>
            <input type="hidden" id="destination_lat" name="destination_lat"/>
            <input type="hidden" id="destination_lng" name="destination_lng"/>
    			  
    			  <button type="submit" style="background: transparent url(<?=site_url('images/baricon.png')?>) no-repeat 0 0;  height:71px; width:70px; position:absolute; top:9px; right:1px; text-indent:-10000px; cursor:pointer; border:0 none; padding:0; ">Go</button>
    		  </form>
    		</div>
    		<div style="font-size:40px; font-weight:bold; color:white; margin-right:470px; text-align:left;">
    		  Collaborative travel planning made easy.
        </div>
  		</div>
  		
  
      <!-- AUTO LOC LIST -->
      <div id="auto-loc-list" style="position:absolute; top:257px; left:540px; background:#EAEAEA; opacity:0.9; width:350px; text-align:left;">
        <ul id="location-autosuggest"></ul>
      </div><!-- AUTO LOC LIST ENDS -->
  
  	</div><!-- MAIN ENDS -->
	</div><!-- WRAPPER ENDS -->
	
  <?=$this->load->view('footer')?>

	<script>
	
	$('#baricon').click(function() {
	  $('#destination').submit();
	});
	
	$(document).ready(function () {	    
    $('#destination-input').focus(function() {
      if ($(this).val() == 'Where do you want to go?') {
        $(this).val('');
      }
    }).blur(function() {
      if ($.trim($(this).val()) == '') {
        $(this).val('Where do you want to go?');
      }
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
    $('#destination-input').keyup(function() {
      map.delay(map.geocodeLocationQuery, 250);
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
    var query = $('#destination-input').val().trim();
      
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
    li.html('<a href="#" style="text-decoration:none; color:navy; font-size:18px; font-weight:bold;">'+resultItem.formatted_address+'</a>');
    li.click(function(){
      map.clickGeocodeResult(resultItem);
      return false;
    });
    $('#location-autosuggest').append(li);
  };

  map.clickGeocodeResult = function(resultItem) {
    $('#destination-input').val(resultItem.formatted_address);
    $('#location-autosuggest').empty();
    $('#destination_lat').val(resultItem.geometry.location.lat());
    $('#destination_lng').val(resultItem.geometry.location.lng());
  };
	</script>

</body>
</html>