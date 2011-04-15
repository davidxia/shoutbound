// bind onkeyup event to location-search-box
$('#location-search-box').keyup(function() {
  map.delay(map.geocodeLocationQuery, 200);
});


// delay geocoder api for 1/5 second of keyboard inactivity
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
  var query = $('#location-search-box').val().trim();
    
  // geocode request sent after user stops typing for 1/5 second
  if (query.length > 1) {
    var request = {
      'address': query,
      'bounds': map.googleMap.getBounds()
    };
    geocoder.geocode(request, map.returnGeocodeResult);
  } else {
  	$('#location-autosuggest').html('');
    if (typeof map.newMarker != 'undefined') {
      map.newMarker.setMap(null);
    }
  	$('.location-data').val('');
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
  li.html('<a href="#">'+resultItem.formatted_address+'</a>');
  li.click(function(){
    map.dropMapMarker(resultItem);
    $('.place_name').html(resultItem.address_components[0].long_name);
    $('#place_type_dropdown').removeClass('hidden');
    $('#marker-notification').show();
    setTimeout("$('#marker-notification').hide();", 15000);
    return false;
  });
  $('#location-autosuggest').append(li);
};


map.dropMapMarker = function(resultItem) {
  $('#location-search-box').val(resultItem.formatted_address);
  resultItem.geometry && resultItem.geometry.viewport && map.googleMap.fitBounds(resultItem.geometry.viewport);
  $('#location-autosuggest').empty();
  
  var evnt = google.maps.event.addListener(map.googleMap, 'tilesloaded', function() {
    if (map.newMarker && map.newMarker.getMap) {
      map.newMarker.setMap(null);
    }
    map.newMarker = new google.maps.Marker({
      map: map.googleMap,
      animation: google.maps.Animation.DROP,
      draggable: true,
      position: resultItem.geometry.location,
      zIndex: 9999,
      maxWidth: 400,
      icon: new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/shoutbound_marker.png')
    });

    // remove listener to prevent marker from dropping if map is dragged
    google.maps.event.removeListener(evnt);

    // display infowindow with data on the place
    map.infoWindow.setContent('<div style="width:300px; height:130px"><label>Name</label><input id="infowindow-name" type="text" value="'+resultItem.address_components[0].long_name+'" /><br/><label>Address</label><input id="infowindow-address" type="text" value="'+resultItem.formatted_address+'" /><br/><label>Phone</label><input id="infowindow-phone" type="text"><div style="padding-left:100px;" /><a href="#" id="infowindow-add" style="text-decoration:none;">Add</a></div></div>');
    setTimeout('map.infoWindow.open(map.googleMap, map.newMarker);', 700);
    
    // clear previous infowindow domready listeners
    google.maps.event.clearListeners(map.infoWindow, 'domready');
    // TODO: how to put into separate function??
    google.maps.event.addListener(map.infoWindow, 'domready', function() {
      $('#infowindow-add').click(function() {
        map.saveMarkerData();
        $(this).unbind();
        map.infoWindow.close();
        return false;
      });
    });

        
    // clicking on marker reopens infowindow
    google.maps.event.addListener(map.newMarker, 'click', function() {
      map.infoWindow.open(map.googleMap, map.newMarker);
    });
    google.maps.event.addListener(map.newMarker, 'dragstart', function() {
      map.infoWindow.close();
      $('#marker-notification').hide();
    });
    google.maps.event.addListener(map.newMarker, 'dragend', function(){
      map.updateInfoWindow();
    });
  });
};


map.updateInfoWindow = function() {
  google.maps.event.clearListeners(map.infoWindow, 'domready');
  var markerLatLng = map.newMarker.getPosition();
  var markerReverseGeocoder = new google.maps.Geocoder();
  
  // reverse geocode by passing in lat lng
  markerReverseGeocoder.geocode({'latLng': markerLatLng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK && results[0]) {
      map.infoWindow.setContent('<div style="width:300px; height:130px"><label>Name</label><input id="infowindow-name" type="text" /><br/><label>Address</label><input id="infowindow-address" type="text" value="'+results[0].formatted_address+'" /><br/><label>Phone</label><input id="infowindow-phone" type="text"><div style="padding-left:100px;" /><a href="#" id="infowindow-add" style="text-decoration:none;">Add</a></div></div>');
      map.infoWindow.open(map.googleMap, map.newMarker);
      
      // I can't move this to separate function without losing passed results[0]
      google.maps.event.addListener(map.infoWindow, 'domready', function() {
        $('#infowindow-add').click(function() {
          $('#location-search-box').val(results[0].formatted_address);
          map.saveMarkerData();
          $(this).unbind();
          map.infoWindow.close();
          return false;
        });
      });

    } else {
      map.infoWindow.setContent('<div style="width:300px; height:130px"><label>Name</label><input id="infowindow-name" type="text" /><br/><label>Address</label><input id="infowindow-address" type="text" value="" /><br/><label>Phone</label><input id="infowindow-phone" type="text"><div style="padding-left:100px;" /><a href="#" id="infowindow-add" style="text-decoration:none;">Add</a></div></div>');
      map.infoWindow.open(map.googleMap, map.newMarker);
      google.maps.event.addListener(map.infoWindow, 'domready', function() {
        $('#infowindow-add').click(function() {
          $('#location-search-box').val($('#infowindow-address').val());
          map.saveMarkerData();
          $(this).unbind();
          map.infoWindow.close();
          return false;
        });
      });
    }
  });
};