<?

// somephp here

?>

<!DOCTYPE html> 
<html> 
<head> 
    
    <?=$this->load->view('core_header')?>
    
<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 

<style type="text/css">
    * { margin:0; padding: 0;}
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }

#map-canvas { height: 300px;width: 800px }
#console { width: 800px }
#list { width: 300px; float: left; }
#wall { width: 500px; float: right; }
#foot {
    clear: both;
}
</style>

<script type="text/javascript">

var Demo = {
  map: null,
  infoWindow: null
};
  
/**
 * Called when clicking anywhere on the map and closes the info window.
 */
Demo.closeInfoWindow = function() {
  Demo.infoWindow.close();
};
 
/**
 * Opens the shared info window, anchors it to the specified marker, and
 * displays the marker's position as its content.
 */
Demo.openInfoWindow = function(marker) {
  var markerLatLng = marker.getPosition();
  Demo.infoWindow.setContent([
    '<b>Marker position is:</b><br/>',
    markerLatLng.lat(),
    ', ',
    markerLatLng.lng()
  ].join(''));
  Demo.infoWindow.open(Demo.map, marker);
};
    

function initialize() {
    var myOptions = {
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    
    // Try W3C Geolocation (Preferred)
    if(navigator.geolocation) {
      browserSupportFlag = true;
      navigator.geolocation.getCurrentPosition(function(position) {
        initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        map.setCenter(initialLocation);
        
        var marker3 = new google.maps.Marker({
          map: map,
          position: initialLocation,
          draggable: true
        });

        // Register event listeners to each marker to open a shared info
        // window displaying the marker's position when clicked or dragged.
        google.maps.event.addListener(marker3, 'click', function() {
          Demo.openInfoWindow(marker3);
        });
        
        
        console.log(initialLocation);
        
      }, function() {
        handleNoGeolocation(browserSupportFlag);
      });

    } 
    
    

    
    // Try Google Gears Geolocation
    else if (google.gears) {
      browserSupportFlag = true;
      var geo = google.gears.factory.create('beta.geolocation');
      geo.getCurrentPosition(function(position) {
        initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
        map.setCenter(initialLocation);
      }, function() {
        handleNoGeoLocation(browserSupportFlag);
      });
    } 
    
    // Browser doesn't support Geolocation
    else {
      browserSupportFlag = false;
      handleNoGeolocation(browserSupportFlag);
    }
    
    

    function handleNoGeolocation(errorFlag) {
      if (errorFlag == true) {
        alert("Geolocation service failed.");
        initialLocation = siberia;
      } else {
        alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
        initialLocation = siberia;
      }
      map.setCenter(initialLocation);
    }
    
    Demo.infoWindow = new google.maps.InfoWindow();

     // Make the info window close when clicking anywhere on the map.
     google.maps.event.addListener(map, 'click', Demo.closeInfoWindow);
    

    
}
  
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}
  

window.onload = loadScript;

</script> 
</head> 
<body>
  <div id="nn-head">
    
    <h1>noqnok</h1> 
    
  </div>
  
  <div id="nn-body">
      <div id="map-canvas"></div>
      <div id="console">
        <div id="list">
            
            <?=$this->load->view('trip_list', $list_data, true)?>
            
        </div>
        <div id="wall">
            
            <?=$this->load->view('trip_wall', $wall_data, true)?>
            
        </div>
      </div>
      <div id="foot"> qwer qwe rq wer qwer qew </div>
  </div>
    
   









</body> 
</html>