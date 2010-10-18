///////////////////////////////////////////////////////////////////////////
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
          "Nan and Ben live here!"
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
// LIST UTILS

ListUtil = {};

ListUtil.populateListItems = function(){
    
    var tripItems = Constants.Trip.tripItems;
    for (var i=0, ii=tripItems.length; i<ii; i++){
        var item = tripItems[i];
        var location = new google.maps.LatLng(item.lat,item.lon);
        var marker = new google.maps.Marker({
            position: location,
            draggable: false,
            map: Trip.map
        });
        
        Trip.listItemMarkers.push(marker);
        
        
        //list
        var itemEl = $("#trip-item-"+item['itemid']);
        var yelpJson = $.parseJSON(item['yelpjson']);
        var itemMarkup = generateListItemHtml(yelpJson, item['user']['name']);
        itemEl.append(itemMarkup);
        
        //wall
        var wallEl = $("#wall-location-name-"+item['itemid']);
        var wallMarkup = WallUtil.generateWallItemHtml(yelpJson, item['user']['name']);
        wallEl.append(wallMarkup);
        
        
    }
        
};

ListUtil.renderListItems = function(){
    //render on map
};

ListUtil.asyncAddActiveTripItem = function(response){
    // TODO: display the item in the list
    YelpUtil.destroyAllMarkers();
    Trip.closeInfoWindow();
};

ListUtil.rejectItem = function(){
    
};

ListUtil.acceptItem = function(){
    
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
// Wall Utils
WallUtil = {};

WallUtil.updateWall = function(query){
    //console.log(query);
    
    var postData = {
        body: query,
        title: "wall-poast",
        trip_id: Constants.Trip['id'],
        islocation: 0
    };
    
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_add_item',
       data: postData,//Trip.activeTripItem,
       success: ListUtil.asyncAddActiveTripItem
    });
}

WallUtil.generateWallItemHtml = function(biz){

        Trip.activeTripItem = biz;
        
        var text = '&nbsp<a href="'+biz.url+'" target="_blank">'+biz.name+'</a>';

        //text += '<div class="marker">';

        // image and rating
        //text += '<img class="businessimage" src="'+biz.photo_url+'"/>';

        // div start
        //text += '<div class="businessinfo" style="margin-left:60px; margin-top:2px">';
        // name/url
        //text += '<a href="'+biz.url+'" target="_blank">'+biz.name+'</a><br/>';
        /// stars
        //text += '<img class="ratingsimage" src="'+biz.rating_img_url_small+'"/><br/>'

        //if(biz.address1.length)
          //  text += biz.address1 + '<br/>';
        // address2
        //if(biz.address2.length) 
          //  text += biz.address2+ '<br/>';
        // city, state and zip
        //text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
        // phone number
        //if(biz.phone.length)
          ///  text += formatPhoneNumber(biz.phone);
        // Read the reviews
        ///text+='<br>';
        //text += '<br/><a href="'+biz.url+'" target="_blank">Read the reviews »</a><br/>';
        // div end

        //text += '</div></div>';

        //text += '<div class="clear-both"></div>';

        return text;
    
    
}

///////////////////////////////////////////////////////////////////////////
// YELP Utils

YelpUtil = {};

// cache for the search results
YelpUtil.searchMarkers = [];

YelpUtil.constructYelpURL = function(searchTerm, map){
    var mapBounds = map.getBounds();
    var URL = "http://api.yelp.com/" +
        "business_review_search?"+
        "callback=" + "YelpUtil.handleResults" +
        "&term=" + searchTerm + 
        "&num_biz_requested=10" +
        "&tl_lat=" + mapBounds.getSouthWest().lat() +
        "&tl_long=" + mapBounds.getSouthWest().lng() + 
        "&br_lat=" + mapBounds.getNorthEast().lat() + 
        "&br_long=" + mapBounds.getNorthEast().lng() +
        "&ywsid=" + Trip.YWSID;
    return encodeURI(URL);
}


YelpUtil.updateMap = function(searchTerm, map) {
    // turn on spinner animation
    //document.getElementById("spinner").style.visibility = 'visible';

    var yelpRequestURL = YelpUtil.constructYelpURL(searchTerm, map);

    /* clear existing markers */
    YelpUtil.destroyAllMarkers();
    
    /* do the api request */
    var script = document.createElement('script');
    script.src = yelpRequestURL;
    script.type = 'text/javascript';
    var head = document.getElementsByTagName('head').item(0);
    head.appendChild(script);
    return false;
}

YelpUtil.handleResults = function(data) {
    // turn off spinner animation
    //document.getElementById("spinner").style.visibility = 'hidden';
    if(data.message.text == "OK") {
        if (data.businesses.length == 0) {
            
            //TODO: make a pretty alert
            alert("Error: No businesses were found near that location");
            return;
        }
        for(var i=0; i<data.businesses.length; i++) {
            biz = data.businesses[i];
            YelpUtil.createYelpResultMarker(biz, new google.maps.LatLng(biz.latitude, biz.longitude), i);
        }
    }
    else {
        alert("Error: " + data.message.text);
    }
}

YelpUtil.createYelpResultMarker = function(biz, point, markerNum) {
    var infoWindowHtml = generateInfoWindowHtml(biz)
    //var marker = new google.maps.Marker(point);
    
    var marker = new google.maps.Marker({
        map: Trip.map,
        position: point,
        draggable: false
    });
    
    YelpUtil.searchMarkers.push(marker);
    
    // Register event listeners to each marker to open a shared info
    // window displaying the marker's position when clicked or dragged.
    google.maps.event.addListener(marker, 'click', function() {
        YelpUtil.openYelpResultWindow(marker, biz);
    });
    

}

YelpUtil.destroyAllMarkers = function(){
    var markers = YelpUtil.searchMarkers;
    for (var i=0, ii=markers.length; i<ii; i++){
        markers[i].setMap(null);
        //markers[i] = null;
        //TODO: must destroy listener objects too!!!
    }
    
    //reset markers
    YelpUtil.searchMarkers = [];
}

YelpUtil.openYelpResultWindow = function(marker, biz){
    var markerLatLng = marker.getPosition();
    Trip.infoWindow.setContent(
        generateInfoWindowHtml(biz)
    );
    Trip.infoWindow.open(Trip.map, marker);
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
    //&nbsp;based&nbsp;on&nbsp;';
    // reviews
    //text += biz.review_count + '&nbsp;reviews<br/><br />';
    // categories
    //text += formatCategories(biz.categories);
    // neighborhoods
    if(biz.neighborhoods.length)
    //    text += formatNeighborhoods(biz.neighborhoods);
    // address
    text += biz.address1 + '<br/>';
    // address2
    if(biz.address2.length) 
        text += biz.address2+ '<br/>';
    // city, state and zip
    text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
    // phone number
    if(biz.phone.length)
        text += formatPhoneNumber(biz.phone);
    // Read the reviews
    text+='<br>';
    //text += '<br/><a href="'+biz.url+'" target="_blank">Read the reviews »</a><br/>';
    // div end
    
    text += '<a class="suggest-location-text" href="javascript:Trip.addActiveTripItem();">Suggest »</a>'
    
    text += '</div></div>';
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
    //&nbsp;based&nbsp;on&nbsp;';
    // reviews
    //text += biz.review_count + '&nbsp;reviews<br/><br />';
    // categories
    //text += formatCategories(biz.categories);
    // neighborhoods
    //if(biz.neighborhoods.length)
    //    text += formatNeighborhoods(biz.neighborhoods);
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
        text += formatPhoneNumber(biz.phone);
    // Read the reviews
    text+='<br>';
    //text += '<br/><a href="'+biz.url+'" target="_blank">Read the reviews »</a><br/>';
    // div end
    
    text += '<span class="item-by">by </span><span class="item-username">'+userName+'</span>';
    
    text += '</div></div>';
    
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










function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}

$(document).ready(loadScript);