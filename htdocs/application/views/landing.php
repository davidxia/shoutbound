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
  cursor: pointer;
  display:block;
  height:45px;
  line-height:30px;
  text-align:center;
  font-size:18px;
  text-decoration:none;
	color: white;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#44749D), to(##44749D));
	background: -moz-linear-gradient(top,  #44749D,  #44749D);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#44749D', endColorstr='#navy');
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
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
			
	<!--LEFT-->
	<div style="width:450px; float:left; padding:20px; margin-top:45px;">
				
		<h2 style="font-size:52px; line-height:58px; font-weight:bold;">Collaborative travel planning.</h2>

		<!--BAR-->
		<div style="line-height:45px; height:45px; width:400px; margin-top:20px; margin-bottom:20px;">
		  <form id="create-trip" action="trips/create" method="post" style="position:relative; height:45px;">
		    <label for="destination" style="position:absolute; font-size:20px; color:#007EAD; z-index:1; background-color:white; height:45px; padding-left:12px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px;"><span>Where do you want to go?</span></label>
			  <input type="text" id="destination" name="destination" autocomplete="off" style="position:absolute; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; height:33px; width:313px; margin-right:70px; padding-left:10px; font-size:20px; z-index:2; background:transparent; border:1px solid #8F8F8F;"/>
			  <input type="hidden" id="destination_lat" name="destination_lat"/>
        <input type="hidden" id="destination_lng" name="destination_lng"/>
			  <button id="lets-go" type="submit">Let&rsquo;s go!</button>
		  </form>
  		  
	    <!-- AUTO LOC LIST -->
    	<ul id="location-autosuggest" style="position:absolute; background-color:white; width:309px; -moz-border-radius-bottomleft:5px; -moz-border-radius-bottomright:5px; border-bottom-right-radius:5px; border-bottom-left-radius:5px;"></ul>
		</div><!--BAR ENDS-->

		<h3 style="font-size:24px; color:gray; font-weight:normal;">Use Shoutbound to organize group travel plans and get travel advice from friends and family.</h3>
	
	</div><!--LEFT ENDS-->
	
	<!--RIGHT-->
	<div style="">
  	<img src="<?=site_url('images/stockphoto.jpg')?>" width="470" height="407"/>
  </div><!--RIGHT ENDS-->
  
</div><!-- WRAPPER ENDS -->
</div><!-- CONTENT ENDS -->
	  	  	 
<!--BOTTOM-->  		  		 		
<div id="bottom" style="background-color:#EBE7E0; padding:30px 0; border-top:1px solid #BDB8AD; border-bottom:1px solid #BDB8AD;">

	<div id="panel" style="height:170px; padding:30px 0px 30px 0px; width:914px; margin:auto; background-color:white; -moz-box-shadow: 2px 2px 2px 2px gray; -webkit-box-shadow: 2px 2px 2px 2px gray; box-shadow: 2px 2px 2px 2px gray; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; text-align:center;">
	
		<div style="float:left; margin-left:35px; padding-right:29px; width:240px;"><h2>Create a trip</h2><br/><p>Coming to see New York? Dreaming of exploring Tibet? Create a trip for all your travel plans and dreams!</p>
		</div>
	
		<div style="float:left; padding-left:30px; padding-right:29px; border-right:1px solid #C8C8C8; border-left:1px solid #C8C8C8; width:240px;"><h2>Build your trip</h2><br/><p>Invite friends and family to join you on your trips or give you travel advice. Shoutbound organizes and records their responses all in one place.</p>
		</div>
		
		<div style="float:left; margin-left:30px; padding-right:35px; width:240px;"><h2>Go!</h2><br/><p>Use Shoutbound to remember, discover, and experience all the great places your friends and family recommended for you!</p>
		</div>
		
	</div>	
</div><!-- BOTTOM ENDS -->

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
      arrow = {up: 38};
    
    if (keyCode == arrow.up) {
      e.preventDefault();
    }
  });
  
  
  // remove selected formatting on mouseover
  $('#location-autosuggest').mouseover(function() {
    $(this).children().removeClass('selected');
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
    	$('#location-autosuggest').html('').css('border', '0');
    }
  };
  
  
  // this callback function is passed the geocoderResult object
  map.returnGeocodeResult = function(result, status) {
    if (status == google.maps.GeocoderStatus.OK && result[0]) {
    	$('#location-autosuggest').empty().css('border', '1px solid #8F8F8F');
    	var exclude = ['street_address', 'route', 'intersection', 'neighborhood', 'premise', 'subpremise', 'postal_code', 'airport'];
    	for (var i=0; i<result.length; i++) {
    		//console.log(result[i].types);
    		var match = false;
        for (var j=0; j<8; j++) {
          if (jQuery.inArray(exclude[j], result[i].types)!=-1) {
            match = true;
          }
        }
        //console.log(match);
        if (!match) {
          map.listResult(result[i]);
        }
    	}
    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
    	$('#location-autosuggest').html('Aw, we couldn\'t find that place.');
    } else {
    	$('#location-autosuggest').html(status);
    }
  };
  
  
  // selectable dropdown list
  map.listResult = function(resultItem) {
    var li = $('<li style="line-height:25px; padding-left:10px;"></li>');
    li.html('<a href="#" style="font-size:18px;" lat="'+resultItem.geometry.location.lat()+'" lng="'+resultItem.geometry.location.lng()+'">'+resultItem.formatted_address+'</a>');
    
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