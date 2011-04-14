var map = {};

map.googleMap = null;
map.infoWindow = null;
map.markers = {};
map.newMarker = null;


map.fixMapPos = function() {
  var top =$('#map-container').offset().top - parseFloat($('#map-container').css('marginTop').replace(/auto/, 0));
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
};


map.loadGoogleMapScript = function() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.google.com/maps/api/js?sensor=false&callback=map.loadGoogleMap';
  document.body.appendChild(script);
};


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
  
  // mark trip's destinations on map
  map.showDestinationMarkers();

  
  // change viewport to saved latlngbounds
  //var sw = new google.maps.LatLng(map.sBound, map.wBound);
  //var ne = new google.maps.LatLng(map.nBound, map.eBound);
  //var savedLatLngBounds = new google.maps.LatLngBounds(sw, ne);
  //map.googleMap.fitBounds(savedLatLngBounds);
  
    
  // create infoWindow object for map
  map.infoWindow = new google.maps.InfoWindow();

  // display location-based wall posts as markers on map
  //if (typeof wall.wallMarkers != 'undefined') {
    //map.displayWallMarkers();
  //}
  $('a.place').each(function(i) {
    map.displayWallMarkers(i, $(this).attr('lat'), $(this).attr('lng'));
  });
};


map.showDestinationMarkers = function() {
  //var bounds = new google.maps.LatLngBounds();
  for (var key in map.destination_markers) {
    if (map.destination_markers.hasOwnProperty(key)) {
      var markerLatLng = new google.maps.LatLng(map.destination_markers[key]['lat'], map.destination_markers[key]['lng']);
      // add each new marker object to Map.markers array
      new google.maps.Marker({
        map: map.googleMap,
        position: markerLatLng,
        icon: new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/shoutbound_marker.png')
      });
      // extend bounds to include this marker
      //bounds.extend(markerLatLng);
    }
  }
  //if (map.destination_markers.length !== 0) {
    //map.googleMap.fitBounds(bounds);
  //}
}



map.displayWallMarkers = function(i, lat, lng) {
  var markerLatLng = new google.maps.LatLng(lat, lng);
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var image = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
      // 20px width, 34px height
      new google.maps.Size(20, 34),
      // origin at 0,0
      new google.maps.Point(0, 0),
      // anchor at 10,34.
      new google.maps.Point(10, 34));
  var shadow = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
      new google.maps.Size(25, 20),
      new google.maps.Point(40, 14),
      new google.maps.Point(0, 20));
  var xxx = new google.maps.MarkerImage({
    url: 'http://dev.shoutbound.com/david/images/marker_sprite.png'
  });
  var marker = new google.maps.Marker({
    map: map.googleMap,
    position: markerLatLng,
    icon: image,
    shadow: shadow
  });
  
  map.loadMarkerListeners(marker, i);
};


map.loadMarkerListeners = function(marker, i) {
  google.maps.event.addListener(marker, 'click', function() {
    // change marker icon
    var image = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
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
      /*$(this).animate({
        backgroundColor: '#ffffff'
      }, 250)*/
      $(document).one('click', function() {
        placeText.css({'background-color': '#ffffff'});
        console.log('d');
        
        image = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
          new google.maps.Size(20, 34),
          new google.maps.Point(0, 0),
          new google.maps.Point(10, 34));
        marker.setOptions({
          icon: image
        });
      });
    });
    
    // scroll window to corresponding wallitem
    window.scrollTo(0, placeText.parent().parent().offset().top);
  });
};


$(document).ready(function() {
  map.fixMapPos();
  map.loadGoogleMapScript();
});