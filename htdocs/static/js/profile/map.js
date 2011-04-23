var map = {};

map.googleMap;

$(function() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.google.com/maps/api/js?sensor=false&callback=map.loadGoogleMap';
  document.body.appendChild(script);
});


map.loadGoogleMap = function() {
  var mapOptions = {
  	disableDefaultUI: true,
  	mapTypeControl: true,
  	mapTypeControlOptions: {
  	  mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE]
    },
  	zoomControl: true,
  	zoomControlOptions: {
      style: google.maps.ZoomControlStyle.LARGE,
    },
  	zoom: 0,
  	center: new google.maps.LatLng(0,0),
  	mapTypeId: google.maps.MapTypeId.ROADMAP,    
    scrollwheel: false
  };
  
  map.googleMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  if ($('.destination').length > 0) {  
    google.maps.event.addListenerOnce(map.googleMap, 'bounds_changed', function() {
      $('.destination').each(function() {
        map.showDestMarkers($(this).attr('lat'), $(this).attr('lng'));
      });
    });
  }
};


map.showDestMarkers = function(lat, lng) {
  var markerLatLng = new google.maps.LatLng(lat, lng);
  var image = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
      new google.maps.Size(20, 34),
      new google.maps.Point(0, 0),
      new google.maps.Point(10, 34));
  var shadow = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
      new google.maps.Size(25, 20),
      new google.maps.Point(40, 14),
      new google.maps.Point(0, 20));
  var marker = new google.maps.Marker({
    map: map.googleMap,
    position: markerLatLng,
    icon: image,
    shadow: shadow
  });
  
  var bounds = map.googleMap.getBounds();
  if (!bounds.contains(markerLatLng)) {
    bounds.extend(markerLatLng);
    map.googleMap.fitBounds(bounds);
  }
};


$(function() {
  $('abbr.timeago').timeago();
});


$(function() {
  if (isSelf) {
    $('#profile-pic-container').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
    $('#edit-profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
  }
});


$('#follow').click(function() {
  $.post(baseUrl+'friends/ajax_add_following', {profileId:profileId},
    function(data) {
      if (data == 1) {
        $('#follow').remove();
        $('#profile-col-right').prepend('Following');
      } else {
        alert('something broken, tell David');
      }
    });
  return false;
});


$(function() {
	$(".main-tab-content").hide();
	$("ul.main-tabs li:first").addClass("active").show(); //Activate first tab
	$(".main-tab-content:first").show(); //Show first tab content

	//On Click Event
	$("ul.main-tabs li").click(function() {

		$("ul.main-tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".main-tab-content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).show(); //Fade in the active ID content
		return false;
	});


  //On Click Event-James
	$("ul.stats-list li a").click(function() {

    $("ul.main-tabs li").removeClass("active");
		var activeTab = $(this).attr('href');
		console.log(activeTab);
		$(".main-tab-content").hide();

		var activeTab = $(this).attr("href");
    $('.main-tabs').find('a[href='+activeTab+']').parent().addClass('active');
		$(activeTab).show();
		return false;
	});

});


$(function() {
  var delay;
  $('.tooltip').mouseover(function() {
    var img = $(this);
    
    delay = setTimeout(function() {
      var title = img.attr('alt');

      // element location and dimensions
      var element_offset = img.offset(),
          element_top = element_offset.top,
          element_left = element_offset.left,
          element_height = img.height(),
          element_width = img.width();
      
      var tooltip = $('<div class="tooltip_container"><div class="tooltip_interior">'+title+'</div></div>');
      $('body').append(tooltip);
  
      // tooltip dimensions
      var tooltip_height  = tooltip.height();
      var tooltip_width = tooltip.width();
      tooltip.css({ top: (element_top + element_height + 3) + 'px' });
      tooltip.css({ left: (element_left - (tooltip_width / 2) + (element_width / 2)) + 'px' });
    }, 200);
  }).mouseout(function() {
    $('.tooltip_container').remove();
    clearTimeout(delay);
  });
});