<!DOCTYPE html>
<html>
    <head>
  	    <title>NoqNok :: Geolocate Demo v2.0</title>
    
	    <link rel="stylesheet" type="text/css" href="http://dev.noqnok.com/david/static/css/trip.css"/>
		
		<!--move this to css file later-->
	    <!--<style type="text/css">
		    #suggest_list {color: blue; cursor:pointer; position:relative}
		    .list_item {background-color:white;}
		    #suggest_list li:hover {background-color: #cccccc;}
        </style>-->
		
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
            
            <!--google maps javascript api tutorial told me to include this, do I need to?-->
            <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        </head>
  
	    <body>
		    </br>
		    <div align="center">
			    <input type="text" size="60" id="trip-where"
                onkeyup="geocode()"
                onchange="mapFirst()"
                onfocus="this.select()"
                autocomplete="off"
                title="Type placename or address" />
      
			    <ol id="suggest_list"></ol>
      
			    </br>
      
			    <div id="map-shell">
    				<div id="map-toolbar"></div>
    				<div id="map-canvas"></div>
    			</div>
		    </div>
		
		<script type="text/javascript">
			// map options (we should probably pull several of the controls)
			var mapOptions = {
				zoom: 1
				,center: new google.maps.LatLng(0, 0)
				,mapTypeId: google.maps.MapTypeId.ROADMAP
				//,scaleControl: true
				//,scrollwheel: false
			};
			
			// display world map
			var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
			 
			// create new geocoder to resolve city names into long/lat co-ords
			var geocoder = new google.maps.Geocoder();
			geocoder.firstItem = {};
			 
			function geocode() {
				var query = document.getElementById("trip-where").value;
				if(query && query.trim) { query = query.trim(); }// trim space if browser supports
				if(query != geocoder.resultAddress && query.length > 1) { // no useless request
					clearTimeout(geocoder.waitingDelay);
					geocoder.waitingDelay = setTimeout(function(){
						geocoder.geocode({'address': query}, geocodeResult);
					}, 300);
				} else {
					document.getElementById("suggest_list").innerHTML =  "";
					geocoder.resultAddress = "";
					geocoder.resultBounds = null;
				}
				
				// callback function
				function geocodeResult(response, status) {
					if (status == google.maps.GeocoderStatus.OK && response[0]) {
						geocoder.firstItem = response[0];
						clearListItems();
						//var len = response.length;
						for(var i=0; i<response.length; i++){
						    //David: we won't limit to only political types for now
							//for(var j=0; j<response[i].types.length; j++){
								//if (response[i].types[j] == 'political')
									addListItem(response[i]);
							//}
						}
					} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
						document.getElementById("suggest_list").innerHTML =  "?";//how to display retry message for user without going to random place on the map?
						geocoder.resultAddress = "";
						geocoder.resultBounds = null;
					} else {
						document.getElementById("suggest_list").innerHTML =  status;
						geocoder.resultAddress = "";
						geocoder.resultBounds = null;
					}
				}
			}
			// by click on list
			// function executed twice to override mapFirst()
			function updateMap(respons){
				function doIt(respons){
					respons.geometry && respons.geometry.viewport && map.fitBounds(respons.geometry.viewport);
					document.getElementById("trip-where").value = respons.formatted_address;
					clearListItems();
				}
				doIt(respons);
				setTimeout(function(){doIt(respons)},500);
			}
			// by onchange
			function mapFirst(){
				geocoder.firstItem.geometry && geocoder.firstItem.geometry.viewport
					&& map.fitBounds(geocoder.firstItem.geometry.viewport);
				document.getElementById("trip-where").value = geocoder.firstItem.formatted_address;
				setTimeout(function(){clearListItems()},1000);
			}
		 
			 			
			// Selectable dropdown list
			var listContainer = document.getElementById("suggest_list");
			function addListItem(resp){
				var loc = resp || {};
				var row = document.createElement("li");
				row.innerHTML = loc.formatted_address;
				row.className = "list_item";
				row.onclick = function(){
					updateMap(loc);
				}
				listContainer.appendChild(row);
			}
			// clear list
			function clearListItems(){
				while(listContainer.firstChild){
					listContainer.removeChild(listContainer.firstChild);
				}
			}
			 
			</script>
 
  </body>
</html>
 
 

