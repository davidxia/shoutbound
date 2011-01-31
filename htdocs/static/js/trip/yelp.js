YelpUtil = {
    
    // Yelp API key
    YWSID: "6SKv1Kx6OghWFgTo_FQtXQ",
    markers: [],
    listeners: [],
    
    constructURL: function(searchTerm, map) {
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
            "&ywsid=" + YelpUtil.YWSID;
        return encodeURI(URL);
    },
    
    search: function(query, map) {
        YelpUtil.resetMap();

        var script = document.createElement('script');
        script.src = YelpUtil.constructURL(query, map);
        script.type = 'text/javascript';
        var head = document.getElementsByTagName('head').item(0);
        head.appendChild(script);
        return false;
    },
    
    resetMap: function() {
        // clear markers and listener objects on the map
        for (var i=0; i<YelpUtil.markers.length; i++) {
            YelpUtil.markers[i].setMap(null);
            google.maps.event.removeListener(YelpUtil.listeners[i]);
        }
        // clear arrays of marker and listener objects 
        YelpUtil.markers = [];
        YelpUtil.listeners = [];
        Map.infoWindow.close();
    },
    
    handleResults: function(data) {
        if(data.message.text == "OK") {
            if (data.businesses.length == 0) {
                //TODO: make a pretty alert
                alert("Error: No businesses were found near that location");
            }

            $("#trip-wall-suggest-list").empty();

            for(var i=0; i<data.businesses.length; i++) {
                var yelpBiz = data.businesses[i];
                var marker = YelpUtil.createMarker(yelpBiz, new google.maps.LatLng(yelpBiz.latitude, yelpBiz.longitude));
                $("#trip-wall-suggest-list").append(YelpUtil.listResult(yelpBiz, marker));
            }
        } else {
            alert("Error: " + data.message.text);
        }
    },
    
    createMarker: function(yelpBiz, latLng) {
        var infoWindowHtml = Map.generateInfoWindowHtml(yelpBiz);

        var marker = new google.maps.Marker({
            map: Map.map,
            position: latLng,
            draggable: false,
            icon: staticUrl + '/images/marker_star.png',
            showInfoWindow: function(){
                YelpUtil.openInfoWindow(marker, yelpBiz);
            }
        });

        YelpUtil.markers.push(marker);

        // Attach an event listener to each marker to display bubble when clicked.
        // Store the returned listener object in array so we can remove them when we make a new API call.
        YelpUtil.listeners.push(google.maps.event.addListener(marker, 'click', marker.showInfoWindow));
        return marker;
    },
    
    openInfoWindow: function(marker, yelpBiz) {
        Map.infoWindow.setContent(Map.generateInfoWindowHtml(yelpBiz));
        Map.infoWindow.open(Map.map, marker);
    },
    
    listResult: function(biz, marker) {
        var resultList = document.createElement('li');
        var anchor = document.createElement('a');
        anchor.innerHTML = biz.name;
        var aa = $(anchor)
        $(resultList).append(aa);

        $(resultList).addClass("search-result-li").click(function(){
            marker.showInfoWindow();
        });
        return resultList;
    }
    
};