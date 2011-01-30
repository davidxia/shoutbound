Create = {};

Create.showCreateDialog = function() {
    $.ajax({
        url: baseUrl + 'trip/ajax_panel_create_trip',
        success: Create.displayCreateDialog
    });

}


Create.displayCreateDialog = function(responseString) {
    var response = $.parseJSON(responseString);
    $("#div_to_popup").empty();
    $("#div_to_popup").append(response["data"]);
    $("#div_to_popup").bPopup();
    
    $('#trip-create-confirm').bind('click', Create.confirmCreate);
    $('#trip-create-cancel').bind('click', Create.hideCreateDialog);    
}


Create.hideCreateDialog = function(){
    $("#div_to_popup").bPopup().close();
}

Create.confirmCreate = function(){
    var tripWhat = $("#trip-what").val();
        
    var postData = {
        tripWhat: tripWhat,
        lat: 40.7144816,
        lon: -73.9909809,
    }
    
    if(tripWhat){
        $.ajax({
           type:'POST',
           url: baseUrl + 'trip/ajax_create_trip',
           data: postData,
           success: confirmAddTrip
        });
    } else {
        alert("Please name your trip! You will be glad you did.")
    }
}


Create.confirmAddTrip = function (response){
    var r = $.parseJSON(response);
    window.location = baseUrl + "trip/details/"+r['tripid'];
}