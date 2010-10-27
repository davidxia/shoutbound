function initialize(){
    
    $("#create-trip-button").click(showCreateTripWindow);
    
}

function showCreateTripWindow(eventObject) {
    $('#profile-content').hide();
    $("#create-trip-window").slideDown('slow');
}

function hideCreateTripWindow() {
    $("#create-trip-window").hide();
    $('#profile-content').show();
}

$(document).ready(initialize);