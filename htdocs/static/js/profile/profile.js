function initialize(){
    
    $("#create-trip-button").click(showCreateTripWindow);
    $("#save-trip-button").click(saveNewTrip);
}

function showCreateTripWindow(eventObject) {
    $('#profile-content').hide();
    $("#create-trip-window").slideDown('slow');
}

function hideCreateTripWindow() {
    $("#create-trip-window").hide();
    $('#profile-content').show();
}

function saveNewTrip(){
    var tripName = $("#trip-name").val();
    
    ///$udata['home_lat'] = 40.7144816;
    ///$udata['home_lon'] = -73.9909809;
    
    var postData = {
        tripname: tripName,
        lat: 40.7144816,
        lon: -73.9909809,
        
    }
    
    if(tripName){
        $.ajax({
           type:'POST',
           url: Constants['siteUrl']+'trip/ajax_create_new_trip',
           data: postData,
           success: confirmAddTrip
        });
    } else {
        alert("Please name your trip! You will be glad you did.")
    }
}

function confirmAddTrip(response){
    var r = $.parseJSON(response);
    window.location = Constants.siteUrl+"trip/details/"+r['tripid'];
}

//adjust the height to fit grid

$(document).ready(initialize);