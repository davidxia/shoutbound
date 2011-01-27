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


YelpUtil.updateMap = function(query, map) {
    var yelpRequestURL = YelpUtil.constructYelpURL(query, map);
    YelpUtil.destroyAllMarkers();
    
    var script = document.createElement('script');
    script.src = yelpRequestURL;
    script.type = 'text/javascript';
    var head = document.getElementsByTagName('head').item(0);
    head.appendChild(script);
    return false;
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


YelpUtil.handleResults = function(data) {
    if(data.message.text == "OK") {
        if (data.businesses.length == 0) {
            //TODO: make a pretty alert
            alert("Error: No businesses were found near that location");
        }
        
        $("#trip-wall-suggest-list").empty();
        
        for(var i=0; i<data.businesses.length; i++) {
            var yelpBiz = data.businesses[i];
            var yelpPin = YelpUtil.createYelpResultMarker(yelpBiz, new google.maps.LatLng(yelpBiz.latitude, yelpBiz.longitude), i);
            $("#trip-wall-suggest-list").append(YelpUtil.addYelpResultToResultList(yelpBiz, yelpPin));
        }
    } else {
        alert("Error: " + data.message.text);
    }
}


YelpUtil.createYelpResultMarker = function(yelpBiz, latLng, markerNum) {
    var infoWindowHtml = generateInfoWindowHtml(yelpBiz)
    
    var marker = new google.maps.Marker({
        map: map,
        position: latLng,
        draggable: false,
        icon: Constants.staticUrl+'/images/marker_star.png',
        showInfoWindow: function(){
            YelpUtil.openYelpResultWindow(marker, yelpBiz);
        }
    });
    
    YelpUtil.searchMarkers.push(marker);
    
    // Register event listeners to each marker to open a shared info
    // window displaying the marker's position when clicked.
    google.maps.event.addListener(marker, 'click', marker.showInfoWindow);
    return marker;
}


YelpUtil.openYelpResultWindow = function(marker, yelpBiz){
    infoWindow.setContent(generateSearchInfoWindowHtml(yelpBiz));
    infoWindow.open(map, marker);
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


YelpUtil.destroyAllSearchListItems = function(){
    //reset list
    var myUl = $("#trip-wall-suggest-list");
    myUl.empty();
}