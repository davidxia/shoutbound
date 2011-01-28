// TRIP NAMESPACE

Map = {
    map: null,
    infoWindow: null,
    activeTripItem: null,
  
    listItemMarkers: []
  
    //closeInfoWindow: function() {
      //Trip.infoWindow.close();
    //},

};




///////////////////////////////////////////////////////////////////////////
// INITIALIZE FUNCTION

function initialize() {
    
    ///////////////////////////////////////////////////////////////////////////
    // INITIALIZE MAP
	var mapOptions = {
		zoom: 5
		,center: new google.maps.LatLng(Constants.Trip['lat'], Constants.Trip['lng'])
		,mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	// display world map; used get(0) to get DOM element from jQuery selector's returned array
	Map.map = new google.maps.Map($('#map-canvas').get(0), mapOptions);
	
	// change viewport to saved latlngbounds
	var sw = new google.maps.LatLng(Constants.Trip['sBound'], Constants.Trip['wBound']);
	var ne = new google.maps.LatLng(Constants.Trip['nBound'], Constants.Trip['eBound']);
	var savedLatLngBounds = new google.maps.LatLngBounds (sw, ne);
	Map.map.fitBounds(savedLatLngBounds);
	
    Map.infoWindow = new google.maps.InfoWindow();

}
///////////////////////////////////////////////////////////////////////////

/*
 * Formats and returns the Info Window HTML 
 * (displayed in a balloon when a marker is clicked)
 */
function generateInfoWindowHtml(biz) {
    
    Map.activeTripItem = biz;
    //console.log($.JSON.encode(Map.activeTripItem));
    
    var text = '<div class="marker">';

    // image and rating
    text += '<img class="businessimage" src="'+biz.photo_url+'"/>';

    // div start
    text += '<div class="businessinfo">';
    // name/url
    text += '<a href="'+biz.url+'" target="_blank">'+biz.name+'</a><br/>';
    // stars
    text += '<img class="ratingsimage" src="'+biz.rating_img_url_small+'"/><br/>';
    // address
    text += biz.address1 + '<br/>';
    // address2
    if(biz.address2.length) 
        text += biz.address2+ '<br/>';
    // city, state and zip
    text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
    // phone number
    if(biz.phone.length)
        text += formatPhoneNumber(biz.phone) + '<br/>';
        
    return text;
}

/*
 * Formats and returns the Info Window HTML 
 * (displayed in a balloon when a marker is clicked)
 */
function generateSearchInfoWindowHtml(biz) {
    var text = generateInfoWindowHtml(biz);
    text += '<a class="suggest-location-text" href="javascript:addActiveTripItem();">Suggest</a>';
    return text;
}

function generateListItemHtml(biz, userName) {
    
    Map.activeTripItem = biz;
    
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

/*
 * Formats the categories HTML
 */
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
 */
function formatNeighborhoods(neighborhoods) {
    s = 'Neighborhoods: ';
    for(var i=0; i<neighborhoods.length; i++) {
        s += '<a href="' + neighborhoods[i].url + '" target="_blank">' + neighborhoods[i].name + '</a>';
        if (i != neighborhoods.length-1) s += ', ';
    }
    s += '<br/>';
    return s;
}

/*
 * Formats the phone number HTML
 */
function formatPhoneNumber(num) {
    if(num.length != 10) return '';
    return '(' + num.slice(0,3) + ') ' + num.slice(3,6) + '-' + num.slice(6,10) + '<br/>';
}

// RUN!
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}

$(document).ready(loadScript);