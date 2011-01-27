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
        //if(window.console) console.log("adding!");
        var activeTrip = Trip.activeTripItem;
        
        //generate the markup for the next window
        var myTemplate = '<div id="trip-suggest-comment-content">'
            + '<h2>You are suggesting the location: </h2>'
            + '<h2 class="black">#{name}</h2>' 
            +'<div class="panel">'
                +'<h3>Add a comment (optional)</h3><br/>'
                +'<textarea id="trip-suggest-textarea">'
                +'</textarea><br/>'
                +'<div class="nn-window-tb">'
                +'<button id="suggest-confirm" class="nn-window-tb-button">confirm</button>'
                +'<button id="suggest-cancel" class="nn-window-tb-button">cancel</button>'
                +'</div>'
            +'</div>';
        
        
        var myValues = {
           name : activeTrip.name
        };
        
        var myResult = $.tmpl(myTemplate, myValues);
        
        $("#div_to_popup").empty();
        $("#div_to_popup").append(myResult);
        $("#div_to_popup").bPopup();
        
        Trip.bindCommentButtons();
        
    },
    
    bindCommentButtons: function(){
        $('#suggest-confirm').bind('click', Trip.confirmSuggest);
        $('#suggest-cancel').bind('click', Trip.hideSuggestDialog);
    },
    
    hideSuggestDialog: function(){
        $("#div_to_popup").bPopup().close();
    },
    
    confirmSuggest: function(){
        //alert(Trip.activeTripItem.id);
        var activeTrip = Trip.activeTripItem;
        //console.log($.JSON.encode(activeTrip));
        
        
        
        var postData = {
            yelp_id: activeTrip.id,
            lat: activeTrip.latitude,
            lon: activeTrip.longitude,
            title: activeTrip.name,
            body: $('#trip-suggest-textarea').val(),
            trip_id: Constants.Trip['id'],
            yelpjson: $.JSON.encode(activeTrip)
        };
        
        $.ajax({
           type:'POST',
           url: Constants['siteUrl']+'trip/ajax_add_item',
           data: postData,//Trip.activeTripItem,
           success: ListUtil.asyncAddActiveTripItem
        });
        
        Trip.hideSuggestDialog();
    }
    

};




///////////////////////////////////////////////////////////////////////////
// INITIALIZE FUNCTION

function initialize() {
    
    ///////////////////////////////////////////////////////////////////////////
    // INITIALIZE MAP
    


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
    text += '<a class="suggest-location-text" href="javascript:Trip.addActiveTripItem();">Suggest</a>';
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

//$(document).ready(loadScript);