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
        'js/trip/create.js',
    ),
    'css_paths'=>array(
        'css/trip.css',
        'css/grid.css',
    )
);

$this->load->view('core_header', $header_args);

?>

<!--IS THIS JAVASCRIPT??-->
<?php
$latlngbounds = explode(" ", $trip['latlngbounds']);
$mapcenter = explode(" ", $trip['map_center']);
?>

<script>
    Constants.Trip = {};
    Constants.Trip['id'] = <?php echo $trip['tripid']; ?>;
    Constants.Trip['lat'] = <?php echo $mapcenter[0] ?>;
    Constants.Trip['lng'] = <?php echo $mapcenter[1]; ?>;
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
            <?//onchange="mapFirst()"
            //onfocus="this.select()"?>
            autocomplete="off"
            title="Type placename or address" />
            <button type="button" onclick="save()">save location</button>

    	    <ol id="suggest-list"></ol>
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

		 
		// create new geocoder to resolve city names into latlng co-ords
		var geocoder = new google.maps.Geocoder();
		geocoder.firstItem = {};
		
		//save map viewport and map center latlng
		var latLngBounds, mapCenter;
		function save() {
            var postData = {
                latLngBounds: latLngBounds,
                mapCenter: mapCenter,
                tripid: Constants.Trip['id']
            }

            if(latLngBounds) {
                $.ajax({
                   type:'POST',
                   url: Constants['siteUrl']+'trip/ajax_update_map',
                   data: postData,
                   success: function(response){
                       var r = $.parseJSON(response);
                       alert(r['success']);
                   }
                });
            } else { alert("something is wrong!"); }
		}

		 
		function geocode() {
			var query = $('#trip-where').val();
			if(query && query.trim) { query = query.trim(); }// trim space if browser supports
			if(query != geocoder.resultAddress && query.length > 1) { // no useless request
				clearTimeout(geocoder.waitingDelay);
				geocoder.waitingDelay = setTimeout(function(){
					geocoder.geocode({'address': query}, geocodeResult);
				}, 300);
			} else {
				$('#suggest-list').html("");
				geocoder.resultAddress = "";
				geocoder.resultBounds = null;
			}
			//callback function is passed the geocoderResult object
			function geocodeResult(result, status) {
				if (status == google.maps.GeocoderStatus.OK && result[0]) {
					geocoder.firstItem = result[0];
					$('#suggest-list').empty();
					for(var i=0; i<result.length; i++) {
						addListItem(result[i]);
					}
				} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					$('#suggest-list').html("Where the fuck is that?!");
					geocoder.resultAddress = "";
					geocoder.resultBounds = null;
				} else {
					$('#suggest-list').html(status);
					geocoder.resultAddress = "";
					geocoder.resultBounds = null;
				}
			}
		}
		
		
		// Selectable dropdown list
		function addListItem(resultItem) {
			var li = document.createElement("li");
			li.innerHTML = resultItem.formatted_address;
			li.className = "list-item";
			li.onclick = function(){ updateMap(resultItem); }
			$('#suggest-list').append(li);
		}
		

		function updateMap(resultItem) {
		    $('#trip-where').val(resultItem.formatted_address);
			resultItem.geometry && resultItem.geometry.viewport && map.fitBounds(resultItem.geometry.viewport);
			$('#suggest-list').empty();
			latLngBounds = resultItem.geometry.viewport.toString();
            latLngBounds = latLngBounds.replace(/[,()]/g, "");
            mapCenter = resultItem.geometry.viewport.getCenter().toString();
            mapCenter = mapCenter.replace(/[,()]/g, "");
		}
		
		
        ///////////////////////////////////////////////////////////////////////////
        // YELP Integration

        // Set up Yelp AJAX call
        $("#submit-suggestion").click(function(){
            return YelpUtil.updateMap($('#term').val(), Map.map);
        });
        
        //var infoWindow = new google.maps.InfoWindow();
        
        function addActiveTripItem() {


        }

        
	</script>
</body> 
</html>