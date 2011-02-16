var Map = {
    map: null,
    geocoder: null,
    marker: null,
    infoWindow: null,
    wall_markers: null,
    
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
                style: google.maps.ZoomControlStyle.LARGE
            },
    		zoom: 5,
    		center: new google.maps.LatLng(Map.lat, Map.lng),
    		mapTypeId: google.maps.MapTypeId.ROADMAP
    	};
    	// display world map; used get(0) to get DOM element from jQuery selector's returned array
    	Map.map = new google.maps.Map($('#map-canvas').get(0), mapOptions);

    	// change viewport to saved latlngbounds
    	var sw = new google.maps.LatLng(Map.sBound, Map.wBound);
    	var ne = new google.maps.LatLng(Map.nBound, Map.eBound);
    	var savedLatLngBounds = new google.maps.LatLngBounds (sw, ne);
    	Map.map.fitBounds(savedLatLngBounds);
    	
    	
    	// create new geocoder to resolve city names into latlng co-ords
    	Map.geocoder = new google.maps.Geocoder();

        // create marker object for map
        Map.marker = new google.maps.Marker({
            map: Map.map,
            draggable: true
        });        
        
        // create infoWindow object for map
        Map.infoWindow = new google.maps.InfoWindow({
            content: "<table>" +
                 "<tr><td>name:</td> <td><input type='text' id='marker_name'/> </td> </tr>" +
                 "<tr><td>description:</td> <td><input type='text' id='marker_description'/></td> </tr>" +
                 "<tr><td></td><td><input type='button' value='save & close' onclick='Map.saveMapMarker()'/></td></tr>"
        });


        // Clicking on map updates marker position and opens infoWindow
        google.maps.event.addListener(Map.map, "click", function(event){
            Map.marker.setPosition(event.latLng);
            Map.infoWindow.open(Map.map, Map.marker);
        });
        // Infowindow pops up when marker is clicked
        google.maps.event.addListener(Map.marker, "click", function() {
            Map.infoWindow.open(Map.map, Map.marker);
        });

    },
    
    
    geocode: function() {
    	var query = $('#trip-where').val();
    	if(query && query.trim) { query = query.trim(); }// trim space if browser supports
    	if(query != Map.geocoder.resultAddress && query.length > 1) { // no useless request
    		clearTimeout(Map.geocoder.waitingDelay);
    		Map.geocoder.waitingDelay = setTimeout(function(){
    			Map.geocoder.geocode({'address': query}, Map.geocodeResult);
    		}, 300);
    	} else {
    		$('#suggest-list').html("");
    		Map.geocoder.resultAddress = "";
    		Map.geocoder.resultBounds = null;
    	}
    },
    
    // this callback function is passed the geocoderResult object
	geocodeResult: function (result, status) {
		if (status == google.maps.GeocoderStatus.OK && result[0]) {
			$('#suggest-list').empty();
			for(var i=0; i<result.length; i++) {
				Map.listResult(result[i]);
			}
		} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
			$('#suggest-list').html("Where the fuck is that?!");
			Map.geocoder.resultAddress = "";
			Map.geocoder.resultBounds = null;
		} else {
			$('#suggest-list').html(status);
			Map.geocoder.resultAddress = "";
			Map.geocoder.resultBounds = null;
		}
	},
	
	// Selectable dropdown list
    listResult: function(resultItem) {
    	var li = document.createElement("li");
    	li.innerHTML = resultItem.formatted_address;
    	li.className = "list-item";
    	li.onclick = function(){ Map.updateMap(resultItem); }
    	$('#suggest-list').append(li);
    },
    
    updateMap: function(resultItem) {
        $('#trip-where').val(resultItem.formatted_address);
    	resultItem.geometry && resultItem.geometry.viewport && Map.map.fitBounds(resultItem.geometry.viewport);
    	$('#suggest-list').empty();
    	
    	// some regex to get google map center and viewport lat lngs
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
    
    
    saveMapMarker: function(){
        var title = $('input#marker_name').val();
        var body = $('input#marker_description').val();
        var lat = Map.marker.getPosition().lat();
        var lng = Map.marker.getPosition().lat();
        
        // TODO: alert user to fill in name if it's missing
        // or if its > 60 chars 
        
        if(lat && lng && title){
            var postData = {
                tripid: tripid,
                title: title,
                body: body,
                lat: lat,
                lng: lng,
                created: Math.round(new Date().getTime()/1000)
            }
            
            $.ajax({
               type:'POST',
               url: baseUrl + 'trip/save_map_marker',
               data: postData,
               success: function(response){
                   Wall.showPost(response);
                   Map.marker.setMap(null);
               }
            });
        } else { alert("you fucked up somewhere"); }
    },
    
    
    loadWallListeners: function(){
        $('div.location_based').click(function(){
            var lat = $(this).attr('lat');
            var lng = $(this).attr('lng');
            Map.marker.setMap(Map.map);
            Map.marker.setPosition(new google.maps.LatLng(lat, lng));
            Map.map.setCenter(new google.maps.LatLng(lat, lng));
        });
    
    },
    
    
    display_wall_markers: function(){
        wall_markers = new Array();
        $('.location_based').each(function(){
            alert($(this).attr('lng'));
            //wall_markers.push()
        });
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
    }
};


$(document).ready(function(){
    Map.loadScript();
    Map.loadWallListeners();
    Map.display_wall_markers();
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