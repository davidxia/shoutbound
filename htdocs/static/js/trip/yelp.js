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
        
        var myUl = $("#trip-wall-suggest-list");
        myUl.empty();
        
        for(var i=0, ii=data.businesses.length; i<ii; i++) {
            biz = data.businesses[i];
            var m = YelpUtil.createYelpResultMarker(biz, new google.maps.LatLng(biz.latitude, biz.longitude), i);
            myUl.append(YelpUtil.addYelpResultToResultList(biz,m));
        }
    }
    else {
        alert("Error: " + data.message.text);
    }
}

YelpUtil.addYelpResultToResultList = function(biz, linkedMarker) {
    var resultList = document.createElement('li');
    var anchor = document.createElement('a');
    anchor.innerHTML = biz.name;
    var aa = $(anchor)
    $(resultList).append(aa);
    
    $(resultList).addClass("search-result-li").click(function(){
        linkedMarker.showInfoWindow();
    });
    return resultList;
    
    
}

YelpUtil.createYelpResultMarker = function(biz, point, markerNum) {
    var infoWindowHtml = generateInfoWindowHtml(biz)
    //var marker = new google.maps.Marker(point);
    
    var marker = new google.maps.Marker({
        map: Trip.map,
        position: point,
        draggable: false,
        showInfoWindow: function(){
            YelpUtil.openYelpResultWindow(marker, biz);
        }
    });
    
    YelpUtil.searchMarkers.push(marker);
    
    // Register event listeners to each marker to open a shared info
    // window displaying the marker's position when clicked or dragged.
    google.maps.event.addListener(marker, 'click', marker.showInfoWindow);
    
    return marker;
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

YelpUtil.destroyAllSearchListItems = function(){
    //reset list
    var myUl = $("#trip-wall-suggest-list");
    myUl.empty();
}

YelpUtil.openYelpResultWindow = function(marker, biz){
    var markerLatLng = marker.getPosition();
    Trip.infoWindow.setContent(
        generateSearchInfoWindowHtml(biz)
    );
    Trip.infoWindow.open(Trip.map, marker);
}
