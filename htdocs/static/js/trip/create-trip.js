/*
var map = {};

$(document).ready(function() {
  map.loadGoogleMapScript();
});

map.loadGoogleMapScript = function() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.google.com/maps/api/js?sensor=false';
  document.body.appendChild(script);
};

// bind onkeyup event to location-search-box
$('#destination').keyup(function() {
  map.delay(map.geocodeLocationQuery, 1000);
});

// delay geocoder api for 1 second of keyboard inactivity
map.delay = (function() {
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

map.geocodeLocationQuery = function() {
  alert('hiasdfasdf');
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
  li.html('<a href="#">'+resultItem.formatted_address+'</a>');
  li.click(function(){
    map.dropMapMarker(resultItem);
    return false;
  });
  $('#location-autosuggest').append(li);
};

map.clickGeocodeResult = function(resultItem) {
  $('#destination').val(resultItem.formatted_address);
  $('#location-autosuggest').empty();
  
};
*/