var map = {};

map.googleMap = null;
map.infoWindow = null;
map.markers = {};
map.newMarker = null;

map.fixMapPos = function() {
  var sidebar    = $('#map-container'),
      win        = $(window),
      offset     = sidebar.offset(),
      topPadding = 15;
      
  win.scroll(function() {
    if (win.scrollTop() > offset.top) {
      sidebar.stop().animate({
        marginTop: win.scrollTop() - offset.top + topPadding
      }, {
        duration: 200
      });
    } else {
      sidebar.stop().animate({
        marginTop: 0
      });
    }
  });
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
  /*
  //var bounds = new google.maps.LatLngBounds();
  for (var key in wall.wallMarkers) {
    if (wall.wallMarkers.hasOwnProperty(key)) {
      var markerLatLng = new google.maps.LatLng(wall.wallMarkers[key]['lat'], wall.wallMarkers[key]['lng']);
      // add each new marker object to Map.markers array
      map.markers[wall.wallMarkers[key]['suggestionId']] = new google.maps.Marker({
        map: map.googleMap,
        position: markerLatLng
      });
      // extend bounds to include this marker
      //bounds.extend(markerLatLng);
    }
  }
  //if ( ! wall.wallMarkers.length == 0) {
    //map.googleMap.fitBounds(bounds);
  //}
  map.loadWallListeners();
  map.loadMarkerListeners();
  */
  var markerLatLng = new google.maps.LatLng(lat, lng);
  var marker = new google.maps.Marker({
    map: map.googleMap,
    position: markerLatLng
  });
  
  map.loadMarkerListeners(marker, i);
  /*
  google.maps.event.addListener(marker, 'click', function() {
    map.infoWindow.setContent(address);
    map.infoWindow.open(map.googleMap, marker);
  });
  */
};


map.loadMarkerListeners = function(marker, i) {
  google.maps.event.addListener(marker, 'click', function() {
    //map.infoWindow.setContent(address);
    //map.infoWindow.open(map.googleMap, marker);
    $('a.place:eq('+i+')').animate({
      backgroundColor: 'yellow'
    }, 1000, function() {
      $(this).animate({
        backgroundColor: '#ffffff'
      }, 1000)
    });
  });
  //map.openMarkerInfoWindow(i);
};



$(document).ready(function() {
  map.loadGoogleMapScript();
  map.fixMapPos();
});