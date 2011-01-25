<!-- HEADER -->
<?
$header_args = array(
    'js_paths'=>array(
        'js/trip/trip.js',
        'js/trip/list.js',
        'js/trip/yelp.js',
        'js/trip/wall.js',
        'js/trip/share.js',
        'js/trip/invite.js',
    ),
    'css_paths'=>array(
        'css/trip.css',
        'css/grid.css',
    )
);

$this->load->view('core_header', $header_args);

?>

<!--IS THIS JAVASCRIPT??-->
<script>
    Constants.Trip = {};
    Constants.Trip['id'] = <?php echo $trip['tripid']; ?>;
    Constants.Trip['zoom'] = 13;
    Constants.Trip['lat'] = <?php echo $trip['lat']; ?>;
    Constants.Trip['lng'] = <?php echo $trip['lon']; ?>;
    <?php $latlngbounds = explode(" ", $trip['latlngbounds']); ?>
    Constants.Trip['sBound'] = <?php echo $latlngbounds[0]; ?>;
    Constants.Trip['wBound'] = <?php echo $latlngbounds[1]; ?>;
    Constants.Trip['nBound'] = <?php echo $latlngbounds[2]; ?>;
    Constants.Trip['eBound'] = <?php echo $latlngbounds[3]; ?>;
</script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<?php echo $this->load->view('core_header_end'); ?>

<body>
  
    <?php echo $this->load->view('core_banner'); ?>
  
    <div id="div_to_popup"></div>
  
    <div id="main" class="container_12">
        <div class="grid_6 push_3" id="trip-name" >
            <?php echo $trip['name']?>
        </div>
        <div class="grid_3">
            <input type="text" size="60" id="trip-where"
            onkeyup="geocode()"
            <?//onchange="mapFirst()"?>
            onfocus="this.select()"
            autocomplete="off"
            title="Type placename or address" />
            <button type="button" onclick="save()">save location</button>

    	    <ol id="suggest_list"></ol>
        </div>
        <div class="clear"></div>

        <div class="grid_3">
        <div id="share-trip">
            <? if($user_type == 'planner'): ?>
                <a href="javascript: Share.showShareDialog();">share this trip</a>
            <? endif; ?>
        </div>
        <div id="invite-trip">
			<?php echo $this->load->view('trip_friends'); ?>
		</div>
		</div>     
        <div class="grid_9">
            <div id="map-shell">
                <div id="map-canvas"></div>
            </div>
        </div>
        <div class="clear"></div>
        
        <div id="console">
            <div id="list" class="grid_3">
                <?php echo $this->load->view('trip_list', $list_data); ?>
            </div>
            <div id="wall" class="grid_9">
                <?php echo $this->load->view('trip_wall', $wall_data); ?>
            </div>
        </div>
      
        <div id="footer">

        </div>
      

  </div>

  <script type="text/javascript">
		var mapOptions = {
			zoom: Constants.Trip['zoom']
			,center: new google.maps.LatLng(Constants.Trip['lat'], Constants.Trip['lng'])
			,mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		// display world map
		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		 
		// create new geocoder to resolve city names into long/lat co-ords
		var geocoder = new google.maps.Geocoder();
		geocoder.firstItem = {};
		
		//a variable to save viewport's latlngbounds to database
		var latLngBounds;
		
		//save map viewport settings
		function save() {
		    
		    
            var postData = {
                latLngBounds: latLngBounds,
                tripid: Constants.Trip['id']
            }

            if(latLngBounds){
                $.ajax({
                   type:'POST',
                   url: Constants['siteUrl']+'trip/ajax_update_latlngbounds',
                   data: postData,
                   success: success
                });
            } else {
                alert("something is wrong!");
            }
		}
		
		function success(response){
            var r = $.parseJSON(response);
            //window.location = Constants.siteUrl+"trip/details/"+r['tripid'];
            alert(r['success']);
        }
		 
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
		    document.getElementById("trip-where").value = respons.formatted_address;
			//function doIt(respons){
				respons.geometry && respons.geometry.viewport && map.fitBounds(respons.geometry.viewport);
				//document.getElementById("trip-where").value = respons.formatted_address;
				clearListItems();
				latLngBounds = respons.geometry.viewport.toString();
				alert(latLngBounds);
			//}
			//doIt(respons);
			//setTimeout(function(){doIt(respons)},500);
		}
		
		// by onchange
		//function mapFirst(){
			//geocoder.firstItem.geometry && geocoder.firstItem.geometry.viewport
				//&& map.fitBounds(geocoder.firstItem.geometry.viewport);
			//document.getElementById("trip-where").value = geocoder.firstItem.formatted_address;
			//clearListItems();
		//}
	 

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