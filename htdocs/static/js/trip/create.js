Create = {};

Create.showCreateDialog = function() {
    $.ajax({
        url: baseUrl+'user/ajax_get_logged_in_uid',
        success: function(response){
            var r = $.parseJSON(response);
            if(r.loggedin){
                $.ajax({
                    url: baseUrl+'trip/ajax_panel_create_trip',
                    success: Create.displayCreateDialog
                });
            }else{
                alert('youre not logged in!');
            }
        }
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
        tripWhat: tripWhat
    }
    
    if(tripWhat){
        $.ajax({
           type:'POST',
           url: baseUrl + 'trip/ajax_create_trip',
           data: postData,
           success: Create.confirmAddTrip
        });
    } else {
        alert("Please name your trip! You will be glad you did.")
    }
}


Create.confirmAddTrip = function (response){
    var r = $.parseJSON(response);
    window.location = baseUrl + "trip/details/"+r['tripid'];
}

$(document).ready(function(){
    $('#create_trip').click(function() {
        Create.showCreateDialog();
        return false;
    });
});