<?
$header_args = array(
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
$this->load->view('core_header_end');

?>
	</head>

<body style="text-align:center; background-color: #E0E0E0; margin:0 0 0 0">

  

	<div id="wrapper" style="margin: 0 auto; width:960px; background:url('<?=site_url('images/hills_and_logo.png')?>'); background-repeat:no-repeat;">
	
	<!-- MAIN -->		
	<div id="main" style="height:761px; position:relative;">
		<a href="<?=site_url('signup')?>">
			<div id="sign-up" style="background:url('<?=site_url('images/sign-up.png')?>'); background-repeat:no-repeat; height:50px; width:150px; z-index:2; position:absolute; top:30px; left:615px; float:left; display:inline block;"></div>
		</a>
		<a href="<?=site_url('login')?>">
			<div id="log-in" style="background:url('<?=site_url('images/login.png')?>'); background-repeat:no-repeat; height:50px; width:150px; z-index:2; position:absolute; top:30px; left:755px; float:left; display:inline block;"></div>
		</a>
		
		<div id="box" style="background: black; opacity:0.6; height:165px; position:absolute; top:130px; width:960px;"></div>
		
		<div id="headline" style="position:absolute; top:150px; left:45px; line-height:40px; font: 45px helvetica neue; font-weight: bold; color:white;">Collaborative travel <br/> planning made easy.</div>

		<div id="bar">
		  <form id="destination" action="trips/create" method="post" style="position:relative;">
			  <input type="text" id="destination-input" name="destination" autocomplete="off" style="border-radius:15px; box-shadow:  0 0 3px 3px gray; -webkit-box-shadow:  0 0 3px 3px gray; background-color:white; position:absolute; top:170px; left:530px;z-index:3; height:75px; width:285px; padding-right:100px; padding-top: 1px; padding-left:15px; padding-bottom:1px; font:22px helvetica neue;font-weight: bold; color:#000080;" value="Where do you want to go?"/>
        <input type="hidden" id="destination_lat" name="destination_lat" />
        <input type="hidden" id="destination_lng" name="destination_lng" />
			  <img id="baricon" src="<?=site_url('images/baricon.png')?>" style="background-repeat:no-repeat; z-index:5; height:75px; width:75px; position:absolute; top:179px; left:855px; cursor:pointer;" />
		  </form>
		</div>
    <!-- AUTO LOC LIST -->
    <div id="auto-loc-list" style="position:absolute; top:257px; left:540px; background:#EAEAEA; opacity:0.9; width:350px; text-align:left;">
      <ul id="location-autosuggest"></ul>
    </div><!-- AUTO LOC LIST ENDS -->

	</div>
	
	<!-- MAIN ENDS -->
	
  <?=$this->load->view('footer')?>
	
	</div>

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