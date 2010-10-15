var Trip = {
  map: null,
  infoWindow: null,
  
  closeInfoWindow: function() {
    Trip.infoWindow.close();
  },
  
  /**
   * Opens the shared info window, anchors it to the specified marker, and
   * displays the marker's position as its content.
   */
  openInfoWindow: function(marker) {
    var markerLatLng = marker.getPosition();
    Trip.infoWindow.setContent([
      '<b>Marker position is:</b><br/>',
      markerLatLng.lat(),
      ', ',
      markerLatLng.lng()
    ].join(''));
    Trip.infoWindow.open(Trip.map, marker);
  },
  
};


function initialize() {
    var myOptions = {
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    //40.7144816, -73.9909809
    var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    

    var initialLocation = new google.maps.LatLng(40.7144816, -73.9909809);
    map.setCenter(initialLocation);
        
    var marker3 = new google.maps.Marker({
        map: map,
        position: initialLocation,
        draggable: true
    });

    // Register event listeners to each marker to open a shared info
    // window displaying the marker's position when clicked or dragged.
    google.maps.event.addListener(marker3, 'click', function() {
        Trip.openInfoWindow(marker3);
    });

    Trip.infoWindow = new google.maps.InfoWindow();

     // Make the info window close when clicking anywhere on the map.
     google.maps.event.addListener(map, 'click', Trip.closeInfoWindow);
     Trip.map = map;
}
  

function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}

$(document).ready(loadScript);