<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css"> 
#lets-go {
  padding: 0 20px;
  cursor: pointer;
  display:block;
  height:61px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:22px;
  text-decoration:none;
	color: white;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  position: absolute;
  right: 0;
  z-index: 3;
  margin: 0;
}
#lets-go:hover {
	background: #007ead;
	background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
	background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
#lets-go:active {
	color: #80bed6;
	background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
	background: -moz-linear-gradient(top,  #0078a5,  #00adee);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}
#auto-loc-list ul li:hover {
  background-color: #E0E0FF;
  cursor:pointer;
}
.selected {
  font-weight:bold;
  background-color: #E0E0FF;
}
</style> 

</head>

<body style="background-color:#1B272C; min-width:960px;">

  <? $this->load->view('header')?>

	<div class="wrapper" style="background-color:white;">
	
  	<!-- CONTENT -->		
  	<div class="content" style="position:relative; margin:0 auto; width:960px;">
  		<div style="text-align:center; padding-top:50px; margin-bottom:30px;">
  		  <img src="<?=site_url('images/stockphoto.jpg')?>" width="520" height="350"/>
  		</div>
  		
  		<ul>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Create</h2>
  		    <p>Create a trip to wherever you want to go. Heading to New York to see the Big Apple? Dreaming of exploring Tibet? Planning a honeymoon in Bali? Create a trip on Shoutbound for all your future travel plans and dreams.</p>
  		  </li>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Receive</h2>
  		    <p>Want to know if anyone's up for joining you in Italy this summer? Looking for authentic dumplings in Hong Kong? Invite your friends and family to join you on your trips or give you travel advice. Shoutbound organizes and records their responses, making it easy to organize group travel and get recommendations from the people you trust.</p>
  		  </li>
  		  <li style="float:left; width:280px; margin:0 20px;">
  		    <h2 style="font-size:28px; margin-bottom:15px;">Go</h2>
  		    <p>On your trip, use Shoutbound to remember, discover, and experience all the great places your friends and family recommended for you.</p>
  		  </li>
  		  <li style="clear:both;"></li>
  		</ul>
  		
  	</div><!-- CONTENT ENDS -->
  	
  	<div style="background:#1b272c; position:relative; top:-380px; left:0;">
      <div style="margin:0 auto; width:700px; padding:15px; line-height:60px; height:60px; position:relative;">
  		  <form id="create-trip" action="trips/create" method="post" style="position:relative;">
    		    <label for="destination" style="position:absolute; font-size:22px; font-weight:bold; color:#87CEEB; z-index:1; background-color:white; width:558px; height:61px; padding:0 100px 0 40px;"><span>Where do you want to go?</span></label>
    			  <input type="text" id="destination" name="destination" autocomplete="off" style="position:absolute; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; height:59px; width:558px; padding:0 100px 0 40px; font-size:22px; font-weight: bold; color:#000080; z-index:2; background:transparent;"/>
    			  <input type="hidden" id="destination_lat" name="destination_lat"/>
            <input type="hidden" id="destination_lng" name="destination_lng"/>
    			  <button id="lets-go" type="submit">Let's go</button>
  		  </form>
  		  
        <!-- AUTO LOC LIST -->
        <div id="auto-loc-list" style="position:absolute; top:76px; left:15px; background-color:white; opacity:0.9; width:570px; text-align:left;">
          <ul id="location-autosuggest"></ul>
        </div><!-- AUTO LOC LIST ENDS -->
      </div>
  	</div>


	</div><!-- WRAPPER ENDS -->

  <? $this->load->view('footer')?>

<script>
  $.fn.labelFader = function() {
    var f = function() {
      var $this = $(this);
      if ($this.val()) {
        $this.siblings('label').children('span').hide();
      } else {
        $this.siblings('label').children('span').fadeIn('fast');
      }
    };
    this.focus(f);
    this.blur(f);
    this.keyup(f);
    this.change(f);
    this.each(f);
    return this;
  };

  $(document).ready(function() {
    $('#destination').focus();
    $('#destination').labelFader();
  });

  
  // allows user to use up/down arrows to select from autosuggest list
  $('#destination').keyup(function(e) {
    var keyCode = e.keyCode || e.which,
        arrow = {up: 38, down: 40};
      
    /*key navigation through elements*/
    if (keyCode == arrow.up || keyCode == arrow.down) {
      var $results = $('#auto-loc-list ul li');
  
      var $current = $results.filter('.selected'),
          $next;
  
      switch (keyCode) {
        case arrow.up:
          $next = $current.prev();
          break;
        case arrow.down:
          if (!$results.hasClass('selected')) {
            $results.first().addClass('selected');
          }
          $next = $current.next();
          break;
      }
  
      //only check next element if up and down key pressed
      if ($next.is('li')) {
        $current.removeClass('selected');
        $next.addClass('selected');
      }
  
      //update text in searchbar
      if ($results.hasClass('selected')) {
        $('#destination').val($('.selected').text());
        $('#destination_lat').val($('.selected').children('a').attr('lat'));
        $('#destination_lng').val($('.selected').children('a').attr('lng'));
      }
  
      //set cursor position
      if (keyCode === arrow.up) {
        return false;
      }

      return;
    }
  });
  
  
  $('#destination').bind('keydown keypress', function(e) {
    var keyCode = e.keyCode || e.which,
      arrow = {up: 38, down: 40};
    
    if (keyCode == arrow.up || keyCode == arrow.enter) {
      e.preventDefault();
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
    $('#destination').keyup(function(e) {
      var keyCode = e.keyCode || e.which;
      // ignore arrow keys
      if (keyCode!==37 && keyCode!==38 && keyCode!==39 && keyCode!==40) {
        map.delay(map.geocodeLocationQuery, 150);
      }
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
    var li = $('<li style="line-height:25px; padding-left:40px;"></li>');
    li.html('<a href="#" style="text-decoration:none; color:navy; font-size:18px;" lat="'+resultItem.geometry.location.lat()+'" lng="'+resultItem.geometry.location.lng()+'">'+resultItem.formatted_address+'</a>');
    
    li.click(function(){
      map.clickGeocodeResult(resultItem);
      return false;
    });
    $('#location-autosuggest').append(li);
  };

  map.clickGeocodeResult = function(resultItem) {
    $('#destination').val(resultItem.formatted_address);
    //$('#location-autosuggest').empty();
    $('#destination_lat').val(resultItem.geometry.location.lat());
    $('#destination_lng').val(resultItem.geometry.location.lng());
    $('#create-trip').submit();
  };
</script>

</body>
</html>