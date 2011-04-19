var map = {};

map.googleMap;
map.infoWindow;

$(function() {
  var top = $('#map-container').offset().top - parseFloat($('#map-container').css('marginTop').replace(/auto/, 0));
  var didScroll = false;
  $(window).scroll(function () {
    didScroll = true;
  });
  
  setInterval(function() {
    if (didScroll) {
      didScroll = false;
      // what is the y position of the scroll?
      var y = $(window).scrollTop();    
      // whether that's below the start of article?
      if (y >= top) {
        // if so, add the fixed class
        $('#map-container').addClass('fixed');
      } else {
        // otherwise, remove it
        $('#map-container').removeClass('fixed');
      }
    }
  }, 100);
});


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
      //position: google.maps.ControlPosition.LEFT_TOP
    },
  	zoom: 11,
  	center: new google.maps.LatLng(map.lat, map.lng),
  	mapTypeId: google.maps.MapTypeId.ROADMAP,    
    scrollwheel: false
  };
  
  // display map inside map-canvas element
  map.googleMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  // mark trip destinations on map
  google.maps.event.addListenerOnce(map.googleMap, 'bounds_changed', function() {
    $('a.destination').each(function() {
      map.showDestMarkers($(this).attr('lat'), $(this).attr('lng'));
    });
  });

  // create infoWindow object for map
  map.infoWindow = new google.maps.InfoWindow();

  // waits until map is set so bounds can be extended to include markers
  google.maps.event.addListenerOnce(map.googleMap, 'bounds_changed', function() {
    $('a.place').each(function(i) {
      map.displayWallMarkers(i, $(this).attr('lat'), $(this).attr('lng'));
    });
  });
  
  // use the first element that is scrollable
  wall.scrollElem = wall.scrollableElement('html', 'body');
};


map.showDestMarkers = function(lat, lng) {
  var markerLatLng = new google.maps.LatLng(lat, lng);
  // Origins, anchor positions and coordinates of the marker
  // increase in X direction to the right in Y direction down.
  var image = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
      // 20px width, 34px height
      new google.maps.Size(20, 34),
      // origin at 0,0
      new google.maps.Point(0, 0),
      // anchor at 10,34.
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


map.displayWallMarkers = function(i, lat, lng) {
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
  
  map.loadMarkerListeners(marker, i);
  wall.bindPlaces(marker, i);
};


map.loadMarkerListeners = function(marker, i) {
  google.maps.event.addListener(marker, 'click', function() {
    // change marker icon
    var image = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
      new google.maps.Size(20, 34),
      new google.maps.Point(20, 0),
      new google.maps.Point(10, 34));
    marker.setOptions({
      icon: image
    });
    
    // highlight corresponding wallitem text
    var placeText = $('a.place:eq('+i+')');
    placeText.animate({
      backgroundColor: '#fffb2c',
    }, 250, function() {
      $(document).one('click', function() {
        // reset text and marker icon when user clicks elsewhere
        placeText.css({'background-color': '#ffffff'});
        
        image = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
          new google.maps.Size(20, 34),
          new google.maps.Point(0, 0),
          new google.maps.Point(10, 34));
        marker.setOptions({
          icon: image
        });
      });
    });
    // scroll window to corresponding wallitem
    $(wall.scrollElem).animate({scrollTop: placeText.parent().parent().offset().top}, 500);
  });
};


map.fitWallMarkers = function() {
  var bounds = map.googleMap.getBounds();
  bounds.extend(markerLatLng);
};