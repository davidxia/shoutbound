var map = {};

map.googleMap = null;
map.infoWindow = null;
map.markers = {};
map.newMarker = null;

map.loadGoogleMapScript = function() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.google.com/maps/api/js?sensor=false&callback=map.loadGoogleMap';
  document.body.appendChild(script);
}

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
  	zoom: 5,
  	center: new google.maps.LatLng(map.lat, map.lng),
  	mapTypeId: google.maps.MapTypeId.ROADMAP,    
    scrollwheel: false
  };
  
  // display map inside map-canvas element
  map.googleMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  
  // change viewport to saved latlngbounds
  var sw = new google.maps.LatLng(map.sBound, map.wBound);
  var ne = new google.maps.LatLng(map.nBound, map.eBound);
  var savedLatLngBounds = new google.maps.LatLngBounds(sw, ne);
  map.googleMap.fitBounds(savedLatLngBounds);
  
  // bind onkeyup event to location-search-box
  $('#location-search-box').keyup(function() {
    map.delay(map.geocodeLocationQuery, 1000);
  });
    
  // create infoWindow object for map
  map.infoWindow = new google.maps.InfoWindow();

  // display location-based wall posts as markers on map
  if (typeof Wall.wall_markers != 'undefined') {
    map.displayWallMarkers();
  }
}


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
  var query = $('#location-search-box').val().trim();
    
  // geocode request sent after user stops typing for 1 second
  if (query.length > 1) {
    geocoder.geocode({'address': query}, map.returnGeocodeResult);
  } else {
  	$('#location-autosuggest').html('');
    if (typeof map.newMarker != 'undefined') {
      map.newMarker.setMap(null);
    }
  	$('.location-data').val('');
  }
}


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
}


// selectable dropdown list
map.listResult = function(resultItem) {
  var li = $('<li></li>');
  li.html('<a href="#">'+resultItem.formatted_address+'</a>');
  li.click(function(){
    map.dropMapMarker(resultItem);
    $('.place_name').html(resultItem.address_components[0].long_name);
    $('#place_type_dropdown').removeClass('hidden');
    $('#place_good_for').removeClass('hidden');
    $('#comment_container').removeClass('hidden');
    $('#marker-notification').show();
    setTimeout("$('#marker-notification').hide();", 15000);
    return false;
  });
  $('#location-autosuggest').append(li);
}


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
        $('#category').show();
        $('#good-for').show();
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
}


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
          $('#category').show();
          $('#good-for').show();
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
          $('#category').show();
          $('#good-for').show();
          map.saveMarkerData();
          $(this).unbind();
          map.infoWindow.close();
          return false;
        });
      });
    }
  });
}


map.saveMarkerData = function() {
  var name = $('#infowindow-name').val();
  var phone = $('#infowindow-phone').val();
  var lat = map.newMarker.getPosition().lat();
  var lng = map.newMarker.getPosition().lng();
    
  if (lat && lng && name) {
    $('#location-name').val(name);
    $('#location-phone').val(phone);
    $('#location-lat').val(lat);
    $('#location-lng').val(lng);
  } else {
    alert('give your place a name');
  }
}


map.displayWallMarkers = function() {
  var bounds = new google.maps.LatLngBounds();
  for (var key in Wall.wall_markers){
    if (Wall.wall_markers.hasOwnProperty(key)) {
      var markerLatLng = new google.maps.LatLng(Wall.wall_markers[key]['lat'], Wall.wall_markers[key]['lng']);
      // add each new marker object to Map.markers array
      map.markers[Wall.wall_markers[key]['itemid']] = new google.maps.Marker({
        map: map.googleMap,
        position: markerLatLng
      });
      // extend bounds to include this marker
      bounds.extend(markerLatLng);
    }
  }
  map.googleMap.fitBounds(bounds);
  map.loadWallListeners();
  map.loadMarkerListeners();
}


map.loadWallListeners = function() {
  for (var i=0; i<Wall.wall_markers.length; i++) {
    // google 'javascript closures in for-loops' to understand what the hell is going on here
    document.getElementById('wall-item-'+Wall.wall_markers[i]['itemid']).onclick = (function(value){
      return function(){
        if (map.newMarker) {
          map.newMarker.setMap(null);
        }
        var locationName = $(this).children('.wall-location-name').html();
        var locationAddress = $(this).children('.wall-location-address').html();
        var locationPhone = $(this).children('.wall-location-phone').html();
        map.infoWindow.setContent('<div style="min-height:30px;">'+locationName+'<br/>'+locationAddress+'<br/>'+locationPhone+'</div>');
        map.infoWindow.open(map.googleMap, map.markers[Wall.wall_markers[value]['itemid']]);
      }                
    })(i);
  }
}


map.loadMarkerListeners = function() {
  for (var i=0; i<Wall.wall_markers.length; i++){
    map.openMarkerInfoWindow(i);
  }
}


// TODO: how to consolidate these two functions?
map.openMarkerInfoWindow = function(i){
  google.maps.event.addListener(map.markers[Wall.wall_markers[i]['itemid']], 'click', function() {
    $('.location_based').removeClass('highlighted');
    var locationName = $('#wall-item-'+Wall.wall_markers[i]['itemid']).children('.wall-location-name').html();
    var locationAddress = $('#wall-item-'+Wall.wall_markers[i]['itemid']).children('.wall-location-address').html();
    var locationPhone = $('#wall-item-'+Wall.wall_markers[i]['itemid']).children('.wall-location-phone').html();
    map.infoWindow.setContent('<div style="min-height:30px;">'+locationName+'<br/>'+locationAddress+'<br/>'+locationPhone+'</div>');
    map.infoWindow.open(map.googleMap, map.markers[Wall.wall_markers[i]['itemid']]);
    $('#wall-content').scrollTo($('#wall-item-'+Wall.wall_markers[i]['itemid']), 500);
    $('.location-based').removeClass('highlighted');
    $('#wall-item-'+Wall.wall_markers[i]['itemid']).addClass('highlighted');
  });
}

$(document).ready(function() {
  map.loadGoogleMapScript();
});