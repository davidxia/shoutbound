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

ListUtil.asyncAddActiveTripItem = function(responseText){
    // TODO: display the item in the list
    YelpUtil.destroyAllMarkers();
    Trip.closeInfoWindow();
    
    
    var response = $.parseJSON(responseText);
    var itemContent = generateListItemHtml($.parseJSON(response.biz), response.name);
    //var commentItem = document
    itemContent = '<div class="list-item-wrap" style="display:none">'+itemContent;
    itemContent += '</div>';
    
    $(itemContent).prependTo('#trip-list-items').fadeIn('slow');
};

ListUtil.rejectItem = function(){
    
};

ListUtil.acceptItem = function(){
    
};