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
  	zoom: 11,
  	center: new google.maps.LatLng(map.lat, map.lng),
  	mapTypeId: google.maps.MapTypeId.ROADMAP,    
    scrollwheel: false
  };
  
  map.googleMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
};


$(function() {
  $('#follow').live('click', function() {
    $.post(baseUrl+'places/ajax_edit_follow', {placeId:placeId, follow:1},
      function(d) {
        console.log(d);
      });
    return false;
  });

  $('#unfollow').live('click', function() {
    $.post(baseUrl+'places/ajax_edit_follow', {placeId:placeId, follow:0},
      function(d) {
        console.log(d);
      });
    return false;
  });
});