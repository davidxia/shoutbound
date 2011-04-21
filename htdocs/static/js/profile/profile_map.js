var map = {};

map.googleMap;
//map.infoWindow;

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
  
  // mark profile's destinations on map
  google.maps.event.addListenerOnce(map.googleMap, 'bounds_changed', function() {
    $('.destination').each(function() {
      map.showDestMarkers($(this).attr('lat'), $(this).attr('lng'));
    });
  });

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
