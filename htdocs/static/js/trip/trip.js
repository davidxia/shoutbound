// TRIP NAMESPACE

Trip = {
    map: null,
    infoWindow: null,
    activeTripItem: null,
  
    listItemMarkers: [],
  
    closeInfoWindow: function() {
      Trip.infoWindow.close();
    },
  
    /**
     * Opens the shared info window, anchors it to the specified marker, and
     * displays the marker's position as its content.
     */
    openInfoWindow: function(marker) {
      var markerLatLng = marker.getPosition();
      Trip.infoWindow.setContent(
          "Welcome to the noqnok tech demo."
      )      
      Trip.infoWindow.open(Trip.map, marker);
    },
    
    addActiveTripItem: function(){
        //alert(Trip.activeTripItem.id);
        var activeTrip = Trip.activeTripItem;
        
        //console.log($.JSON.encode(activeTrip));
        
        var postData = {
            yelp_id: activeTrip.id,
            lat: activeTrip.latitude,
            lon: activeTrip.longitude,
            title: activeTrip.name,
            body: "foo",
            trip_id: Constants.Trip['id'],
            yelpjson: $.JSON.encode(activeTrip)
        };
        
        $.ajax({
           type:'POST',
           url: Constants['siteUrl']+'trip/ajax_add_item',
           data: postData,//Trip.activeTripItem,
           success: ListUtil.asyncAddActiveTripItem
        });
    }
    

};




///////////////////////////////////////////////////////////////////////////
// INITIALIZE FUNCTION

function initialize() {
    
    ///////////////////////////////////////////////////////////////////////////
    // INITIALIZE MAP
    
    var mapOptions = {
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    Trip.map = new google.maps.Map(
        document.getElementById("map-canvas"),
        mapOptions
    );
    
    //alias
    var map = Trip.map;
    
    Trip.infoWindow = new google.maps.InfoWindow();
    
    // TODO: Initial location hardcoded for right now
    var initialLocation = new google.maps.LatLng(40.7338981628418, -73.9925994873047);
    map.setCenter(initialLocation);
        
    var startingMarker = new google.maps.Marker({
        map: map,
        position: initialLocation,
        draggable: false
    });

    // Register event listeners to each marker to open a shared info
    // window displaying the marker's position when clicked or dragged.
    google.maps.event.addListener(startingMarker, 'click', function() {
        Trip.openInfoWindow(startingMarker);
    });


    // Make the info window close when clicking anywhere on the map.
    google.maps.event.addListener(map, 'click', Trip.closeInfoWindow);

    
    ///////////////////////////////////////////////////////////////////////////
    // YELP Integration
    
    // Yelp API key
    Trip.YWSID = "6SKv1Kx6OghWFgTo_FQtXQ";
    
    // Set up Yelp AJAX call
    $("#submit-suggestion").click(function(){
        //TODO: jQuery this guy
        var queryString = document.getElementById("term").value;
        return YelpUtil.updateMap(queryString, map);
    });
    
    // Set up wall comment API call
    $("#submit-wall").click(function(){
        //TODO: jQuery this guy
        var queryString = document.getElementById("wall-comment").value;
        WallUtil.updateWall(queryString);
        document.getElementById("wall-comment").value = "";
    });    
    
    // populate existing trips
    ListUtil.populateListItems();
    
     //map.addControl(new GLargeMapControl());
     //map.addControl(new GMapTypeControl());
     //map.setMapType(G_HYBRID_MAP);
     
     // setup our marker icon
     /*icon = new GIcon();
     icon.image = Constants['staticUrl']+"images/marker_star.png";
     icon.shadow = Constants['staticUrl']+"images/marker_shadow.png";
     icon.iconSize = new GSize(20, 29);
     icon.shadowSize = new GSize(38, 29);
     icon.iconAnchor = new GPoint(15, 29);
     icon.infoWindowAnchor = new GPoint(15, 3);*/ 
}




///////////////////////////////////////////////////////////////////////////

/*
 * Formats and returns the Info Window HTML 
 * (displayed in a balloon when a marker is clicked)
 */
function generateInfoWindowHtml(biz) {
    
    Trip.activeTripItem = biz;
    
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
    text += '<a class="suggest-location-text" href="javascript:Trip.addActiveTripItem();">Suggest</a>'
    
    return text;
}

function generateListItemHtml(biz, userName) {
    
    Trip.activeTripItem = biz;
    
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