var Map = {
    map: null,
    geocoder: null,
    infoWindow: null,
    markers: {},
    new_marker: null,
    
    lat: null,
    lng: null,
    sBound: null,
    wBound: null,
    nBound: null,
    eBound: null,
    
    loadScript: function() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=Map.loadMap";
        document.body.appendChild(script);
    },
    
    loadMap: function() {
        // load google map with options
    	var mapOptions = {
        	disableDefaultUI: true,
        	zoomControl: true,
        	zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.LEFT_TOP
            },
    		zoom: 5,
    		center: new google.maps.LatLng(Map.lat, Map.lng),
    		mapTypeId: google.maps.MapTypeId.ROADMAP,
    		mapTypeControlOptions: {
    		  mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE]
            },
            mapTypeControl: true,
            scrollwheel: false
    	};
    	// display world map; used get(0) to get DOM element from jQuery selector's returned array
    	Map.map = new google.maps.Map($('#map-canvas').get(0), mapOptions);
    	
        // Create a div element to hold our custom control
        Map.marker_control = $('<div></div>');
        // Margin offsets control from map edge
        Map.marker_control.css('margin', '10px');
        Map.marker_control.css('backgroundImage', 'url(http://dev.shoutbound.com/david/images/shoutbound_marker.png)');
        Map.marker_control.css('height', '30px');
        Map.marker_control.css('width', '18px');
        Map.marker_control.css('cursor', 'pointer');
        Map.marker_control.attr('title', 'drag to place a marker on the map');
        // bind click event that drops a marker
        Map.marker_control.click(function(){ Map.add_map_marker(Map.marker_control); });
        Map.map.controls[google.maps.ControlPosition.TOP_LEFT].push(Map.marker_control.get(0));


    	// change viewport to saved latlngbounds
    	var sw = new google.maps.LatLng(Map.sBound, Map.wBound);
    	var ne = new google.maps.LatLng(Map.nBound, Map.eBound);
    	var savedLatLngBounds = new google.maps.LatLngBounds(sw, ne);
    	Map.map.fitBounds(savedLatLngBounds);
    	
    	// bind onkeyup event to location_search_box
    	$('#location_search_box').keyup(function(){
    	    Map.geocode();
    	})

        
        // create infoWindow object for map
        Map.infoWindow = new google.maps.InfoWindow();
        
        // display location-based wall posts as markers on map
        if(typeof Wall.wall_markers != 'undefined')
            Map.display_wall_markers();
    },
    
    
    geocode: function(){
    	// create new geocoder to resolve city names into latlng co-ords
    	Map.geocoder = new google.maps.Geocoder();
    	var query = $('#location_search_box').val();
    	// trim space if browser supports
    	if(query && query.trim) { query = query.trim(); }
        // prevent useless requests
    	if(query != Map.geocoder.resultAddress && query.length > 1) {
    		clearTimeout(Map.geocoder.waitingDelay);
    		Map.geocoder.waitingDelay = setTimeout(function(){
    			Map.geocoder.geocode({'address': query}, Map.geocodeResult);
    		}, 500);
    	} else {
    		$('#location_autosuggest').html('');
    		Map.geocoder.resultAddress = '';
    		Map.geocoder.resultBounds = null;
    	}
    },
    
    // this callback function is passed the geocoderResult object
	geocodeResult: function(result, status){
		if (status == google.maps.GeocoderStatus.OK && result[0]) {
			$('#location_autosuggest').empty();
			for(var i=0; i<result.length; i++) {
				Map.listResult(result[i]);
			}
		} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
			$('#location_autosuggest').html('Where the fuck is that?!');
			Map.geocoder.resultAddress = '';
			Map.geocoder.resultBounds = null;
		} else {
			$('#location_autosuggest').html(status);
			Map.geocoder.resultAddress = '';
			Map.geocoder.resultBounds = null;
		}
	},
	
	// Selectable dropdown list
    listResult: function(resultItem) {
    	var li = $('<li></li>');
    	li.html('<a href="#">'+resultItem.formatted_address+'</a>');
    	li.click(function(){
    	    Map.updateMap(resultItem);
    	    $('.place_name').html(resultItem.address_components[0].long_name);
    	    $('#place_type_dropdown').removeClass('hidden');
    	    $('#place_good_for').removeClass('hidden');
    	    $('#comment_container').removeClass('hidden');
        });
    	$('#location_autosuggest').append(li);
    },
    
    updateMap: function(resultItem) {
        $('#location_search_box').val(resultItem.formatted_address);
    	resultItem.geometry && resultItem.geometry.viewport && Map.map.fitBounds(resultItem.geometry.viewport);
    	$('#location_autosuggest').empty();
    	var evnt = google.maps.event.addListener(Map.map, 'tilesloaded', function(){
    	    if(Map.new_marker && Map.new_marker.getMap)
    	        Map.new_marker.setMap(null);
            Map.new_marker = new google.maps.Marker({
                map: Map.map,
                animation: google.maps.Animation.DROP,
                draggable: false,
                position: resultItem.geometry.location,
                zIndex: 9999,
                icon: new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/shoutbound_marker.png')
            });
            // display infowindow with data on the place
            //console.log(resultItem);
            Map.infoWindow.setContent('<span class="infowindow_text">'+resultItem.formatted_address+'</span>');
            setTimeout('Map.infoWindow.open(Map.map, Map.new_marker);', 700);
            
            // make the marker_control inactive to prevent more pins from being dropped
            Map.marker_control.css('backgroundImage', 'url(http://dev.shoutbound.com/david/images/fb-login-button.png)');
            Map.marker_control.unbind('click');
            Map.marker_control.click(function(){
                Map.remove_map_marker();
            });
            // remove listener to prevent marker from dropping if map is updated
            google.maps.event.removeListener(evnt);
            // clicking on marker reopens infowindow
        	google.maps.event.addListener(Map.new_marker, 'click', function(){
        	    Map.infoWindow.open(Map.map, Map.new_marker);
        	});
    	});
    	
    	// get google map center and viewport lat lngs
        var mapCenter = resultItem.geometry.viewport.getCenter();
        Map.lat = mapCenter.lat();
        Map.lng = mapCenter.lng();
        
    	var neCorner = resultItem.geometry.viewport.getNorthEast();
        var swCorner = resultItem.geometry.viewport.getSouthWest();
        Map.sBound = swCorner.lat();
        Map.wBound = swCorner.lng();
        Map.nBound = neCorner.lat();
        Map.eBound = neCorner.lng();
    },
    
    // save map viewport and map center latlng
    save: function() {
        var postData = {
            lat: Map.lat,
            lng: Map.lng,
            sBound: Map.sBound,
            wBound: Map.wBound,
            nBound: Map.nBound,
            eBound: Map.eBound,
            tripid: tripid
        };

        if(Map.lat && Map.lng && Map.sBound && Map.wBound && Map.nBound && Map.eBound) {
            $.ajax({
               type:'POST',
               url: baseUrl + 'trip/ajax_update_map',
               data: postData,
               success: function(response){
                   var r = $.parseJSON(response);
                   alert(r['success']);
               }
            });
        } else { alert("something is wrong!"); }
    },
    
    
    save_new_marker: function(){
        var name = $('#new_marker_name').val();
        var address = $('#new_marker_address').val();
        var phone = $('#new_marker_phone').val();
        var lat = Map.new_marker.getPosition().lat();
        var lng = Map.new_marker.getPosition().lng();
        
        // TODO: alert user to fill in name if it's missing
        // or if its > 60 chars 
        
        if(lat && lng && name){
            var post_data = {
                tripid: tripid,
                name: name,
                lat: lat,
                lng: lng,
                address: address,
                phone: phone
            }

            $.ajax({
               type:'POST',
               url: baseUrl + 'trip/ajax_save_new_marker',
               data: post_data,
               success: function(response){
                   Wall.show_location_based_post(response);
                   Map.new_marker.setMap(null);
               }
            });
        } else { alert("you fucked up somewhere"); }
    },
    
    
    display_wall_markers: function(){
        var bounds = new google.maps.LatLngBounds();
        for (var key in Wall.wall_markers){
            if (Wall.wall_markers.hasOwnProperty(key)) {
                var marker_lat_lng = new google.maps.LatLng(Wall.wall_markers[key]['lat'], Wall.wall_markers[key]['lng']);
                // add each new marker object to Map.markers array
                // var x = Wall.wall_markers[key]['itemid'];
                Map.markers[Wall.wall_markers[key]['itemid']] = new google.maps.Marker({
                        map: Map.map,
                        position: marker_lat_lng
                    });
                // extend bounds to include this marker
                bounds.extend(marker_lat_lng);
            }
        }
        Map.map.fitBounds(bounds);
        Map.load_wall_listeners();
    },
    
    
    load_wall_listeners: function(){
        for(var i=0; i<Wall.wall_markers.length; i++){
            // google 'javascript closures in for-loops' to understand what the hell is going on here
            document.getElementById('wall-item-'+Wall.wall_markers[i]['itemid']).onclick = (function(value){
                return function(){
                    if(Map.new_marker)
                        Map.remove_map_marker();
                    var location_name = $(this).children('.wall_location_name').html();
                    var location_address = $(this).children('.wall_location_address').html();
                    var location_phone = $(this).children('.wall_location_phone').html();
                    Map.infoWindow.setContent(location_name+'<br/>'+location_address+'<br/>'+location_phone);
                    Map.infoWindow.open(Map.map, Map.markers[Wall.wall_markers[value]['itemid']]);
                }                
            })(i);
        }
    },
    
    // Formats and returns the Info Window HTML (displayed in a balloon when a marker is clicked)
    generateInfoWindowHtml: function(biz) {
        var text = '<div class="marker">';
        // image
        text += '<img class="businessimage" src="'+biz.photo_url+'"/>';
        // div start
        text += '<div class="businessinfo">';
        // name/url
        text += '<a href="'+biz.url+'" target="_blank">'+biz.name+'</a><br/>';
        // stars
        //text += '<img class="ratingsimage" src="'+biz.rating_img_url_small+'"/><br/>';
        // address
        text += biz.address1 + '<br/>';
        // address2
        if(biz.address2.length) 
            text += biz.address2+ '<br/>';
        // city, state and zip
        text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
        // phone number
        if(biz.phone.length)
            text += Map.formatPhoneNumber(biz.phone) + '<br/>';
        //text += '<a class="suggest-location-text" href="javascript:addActiveTripItem();">Suggest</a>';

        return text;
    },
    
    // Formats the phone number HTML for the infoWindow
    formatPhoneNumber: function(num) {
        if(num.length != 10) return '';
        return '(' + num.slice(0,3) + ') ' + num.slice(3,6) + '-' + num.slice(6,10) + '<br/>';
    },
    
    
    add_map_marker: function(){
        // drop a draggable marker in the center of the map
        Map.new_marker = new google.maps.Marker({
            map: Map.map,
            animation: google.maps.Animation.DROP,
            draggable: true,
            position: Map.map.getCenter(),
            zIndex: 9999,
            icon: new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/shoutbound_marker.png')
        });
        // make the marker_control inactive to prevent more pins from being dropped
        Map.marker_control.css('backgroundImage', 'url(http://dev.shoutbound.com/david/images/fb-login-button.png)');
        Map.marker_control.unbind('click');
        Map.marker_control.click(function(){
            Map.remove_map_marker();
        });
        
        // close the infoWindow if it's open
        Map.infoWindow.close();
        // make infoWindow content a form for filling out information
        Map.infoWindow.setContent("<table>" +
                 "<tr><th>name:</th> <td><input type='text' id='new_marker_name'/> </td> </tr>" +
                 "<tr><th>address:</th> <td><input type='text' id='new_marker_address'/></td> </tr>" +
                 "<tr><th>phone:</th> <td><input type='text' id='new_marker_phone'/></td> </tr>" +
                 "<tr><th></th><td><input type='button' value='save & close' onclick='Map.save_new_marker()'/></td></tr>" +
                 "</table>"
        );
        
        // if marker is dragged or clicked, display infowindow
        google.maps.event.addListener(Map.new_marker, 'click', function() {
            Map.infoWindow.open(Map.map, Map.new_marker);
        });
        google.maps.event.addListener(Map.new_marker, 'dragend', function() {
            Map.infoWindow.open(Map.map, Map.new_marker);
        });
        
        // closing infowindow removes marker
        google.maps.event.addListener(Map.infoWindow, 'closeclick', function() {
            Map.remove_map_marker();
        });

    },
    
    
    remove_map_marker: function(){
        // remove the draggable marker
        // TODO: we need graphics!!
        Map.marker_control.css('backgroundImage', 'url(http://dev.shoutbound.com/david/images/shoutbound_marker.png)');
        Map.new_marker.setMap(null);
        Map.marker_control.unbind('click');
        Map.marker_control.click(function(){
            Map.add_map_marker();
        });
    }
};


$(document).ready(function(){
    Map.loadScript();
});



/*
function generateListItemHtml(biz, userName) {
    var text = '<div class="marker">';
    // image and rating
    text += '<img class="businessimage" src="'+biz.photo_url+'"/>';
    // div start
    text += '<div class="businessinfo">';
    // name/url
    text += '<a href="'+biz.url+'" target="_blank">'+biz.name+'</a><br/>';
    // stars
    text += '<img class="ratingsimage" src="'+biz.rating_img_url_small+'"/><br/>'
    // address
    if(biz.address1.length)
        text += biz.address1 + '<br/>';
    // address2
    if(biz.address2.length) 
        text += biz.address2+ '<br/>';
    // city, state and zip
    text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
    // phone number
    if(biz.phone.length)
        text += formatPhoneNumber(biz.phone) + '<br/>';
    
    text += '<span class="item-by">by </span><span class="item-username">'+userName+'</span>';
    
    text += '<div class="clear-both"></div>';
    
    return text;
}


//Formats the categories HTML

function formatCategories(cats) {
    var s = 'Categories: ';
    for(var i=0; i<cats.length; i++) {
        s+= cats[i].name;
        if(i != cats.length-1) s += ', ';
    }
    s += '<br/>';
    return s;
}

/*
 * Formats the neighborhoods HTML
 
function formatNeighborhoods(neighborhoods) {
    s = 'Neighborhoods: ';
    for(var i=0; i<neighborhoods.length; i++) {
        s += '<a href="' + neighborhoods[i].url + '" target="_blank">' + neighborhoods[i].name + '</a>';
        if (i != neighborhoods.length-1) s += ', ';
    }
    s += '<br/>';
    return s;
}*/