var Map = {
    map: null,
    geocoder: null,
    infoWindow: null,
    
    lat: null,
    lng: null,
    sBound: null,
    wBound: null,
    nBound: null,
    eBound: null,
        
    closeInfoWindow: function() {
        Map.infoWindow.close();
    },
    
    loadScript: function() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=Map.loadMap";
        document.body.appendChild(script);
    },
    
    loadMap: function() {
        // load google map with options
    	var mapOptions = {
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

        // create infoWindow object for map
        Map.infoWindow = new google.maps.InfoWindow();
        // Make the info window close when clicking anywhere on the map.
        google.maps.event.addListener(Map.map, 'click', Map.closeInfoWindow);
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
        mapCenter = resultItem.geometry.viewport.getCenter().toString();
        var r = /\((-?\d+.?\d*), (-?\d+.?\d*)\)/;
        mapCenter.match(r);
        Map.lat = RegExp.$1;
        Map.lng = RegExp.$2;
        
    	latLngBounds = resultItem.geometry.viewport.toString();
    	r = /\(\((-?\d+.?\d*), (-?\d+.?\d*)\), \((-?\d+.?\d*), (-?\d+.?\d*)\)\)/;
        latLngBounds.match(r);
        Map.sBound = RegExp.$1;
        Map.wBound = RegExp.$2;
        Map.nBound = RegExp.$3;
        Map.eBound = RegExp.$4;
    },
    
    //save map viewport and map center latlng
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


$(document).ready(Map.loadScript);


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