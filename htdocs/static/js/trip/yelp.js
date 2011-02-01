Yelp = {
    
    // Yelp API key
    YWSID: "6SKv1Kx6OghWFgTo_FQtXQ",
    markers: [],
    listeners: [],
    
    loadYelp: function() {
        // Set up Yelp AJAX call
        $("#submit-suggestion").click(function(){
            return Yelp.search($('#wall-text-input').val(), Map.map);
        });
    },
    
    constructURL: function(searchTerm, map) {
        var mapBounds = map.getBounds();
        var URL = "http://api.yelp.com/" +
            "business_review_search?"+
            "callback=" + "Yelp.handleResults" +
            "&term=" + searchTerm + 
            "&num_biz_requested=10" +
            "&tl_lat=" + mapBounds.getSouthWest().lat() +
            "&tl_long=" + mapBounds.getSouthWest().lng() + 
            "&br_lat=" + mapBounds.getNorthEast().lat() + 
            "&br_long=" + mapBounds.getNorthEast().lng() +
            "&ywsid=" + Yelp.YWSID;
        return encodeURI(URL);
    },
    
    search: function(query, map) {
        Yelp.resetMap();

        var script = document.createElement('script');
        script.src = Yelp.constructURL(query, map);
        script.type = 'text/javascript';
        var head = document.getElementsByTagName('head').item(0);
        head.appendChild(script);
        return false;
    },
    
    resetMap: function() {
        // clear markers and listener objects on the map
        for (var i=0; i<Yelp.markers.length; i++) {
            Yelp.markers[i].setMap(null);
            google.maps.event.removeListener(Yelp.listeners[i]);
        }
        // clear arrays of marker and listener objects 
        Yelp.markers = [];
        Yelp.listeners = [];
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
                var marker = Yelp.createMarker(yelpBiz, new google.maps.LatLng(yelpBiz.latitude, yelpBiz.longitude));
                $("#trip-wall-suggest-list").append(Yelp.listResult(yelpBiz, marker));
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
                Yelp.openInfoWindow(marker, yelpBiz);
            }
        });

        Yelp.markers.push(marker);

        // Attach an event listener to each marker to display bubble when clicked.
        // Store the returned listener object in array so we can remove them when we make a new API call.
        Yelp.listeners.push(google.maps.event.addListener(marker, 'click', marker.showInfoWindow));
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

$(document).ready(Yelp.loadYelp);