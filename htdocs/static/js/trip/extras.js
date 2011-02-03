function saveStartDate(){
    var tripStartYear = $('#trip-start-year').val();
    var tripStartMonth = $('#trip-start-month').val();
    var tripStartDay = $('#trip-start-day').val();
    var r = /\d{2}/;
    if(!tripStartDay.match(r))
        tripStartDay = '0'+tripStartDay;
    
    switch(tripStartMonth){
        case "January": tripStartMonth = "01"; break;
        case "February": tripStartMonth = "02"; break;
        case "March": tripStartMonth = "03"; break;
        case "April": tripStartMonth = "04"; break;
        case "May": tripStartMonth = "05"; break;
        case "June": tripStartMonth = "06"; break;
        case "July": tripStartMonth = "07"; break;
        case "August": tripStartMonth = "08"; break;
        case "September": tripStartMonth = "09"; break;
        case "October": tripStartMonth = "10"; break;
        case "Novemeber": tripStartMonth = "11"; break;
        case "December": tripStartMonth = "11"; break;
        default: tripStartMonth = "01";
    }
    var tripStartDate = tripStartYear+'-'+tripStartMonth+'-'+tripStartDay+' 00:00:00';
    var postData = {
        tripid: tripid,
        tripStartDate: tripStartDate
    };
    $.ajax({
        type: 'POST',
        url: baseUrl + 'trip/save_trip_startdate',
        data: postData,
        success: function(response){
        var r = $.parseJSON(response);
            alert(r['success']);
        }
    });
}

function countdown(){
    //Finding difference between the current time and expiration date
    //in seconds after Epoch
    var now = new Date();
    var current = parseInt(now.getTime()/1000);
    var diff_seconds = tripStartDate - current;
    
    //Number of years left
    var diff_years = parseInt(diff_seconds/(60*60*24*365.25))
    diff_seconds -= diff_years * 60 * 60 * 24 * 365.25;
    if(diff_years != 0){
        if(diff_years == 1){
            $('#years').html(diff_years+' year');
        } else {
            $('#years').html(diff_years+' years');
        }
    }
    
    //Number of days left
    var diff_days = parseInt(diff_seconds/(60*60*24));
    diff_seconds -= diff_days * 60 * 60 * 24;
    if(diff_days != 0){
        if(diff_days == 1){
            $('#days').html(diff_days+' day');
        } else {
            $('#days').html(diff_days+' days');
        }
    }

    //Number of hours left
    var diff_hours = parseInt(diff_seconds/(60*60));
    diff_seconds -= diff_hours * 60 * 60;
    if(diff_hours != 0){
        if(diff_hours == 1){
            $('#hours').html(diff_hours+' hour');
        } else {
            $('#hours').html(diff_hours+' hours');
        }
    }

    //Number of minutes left
    var diff_minutes = parseInt(diff_seconds/(60));
    diff_seconds -= diff_minutes * 60;
    if(diff_minutes != 0){
        if(diff_minutes == 1){
            $('#minutes').html(diff_minutes+' minute');
        } else {
            $('#minutes').html(diff_minutes+' minutes');
        }
    }
    //Number of seconds left
    if(diff_seconds != 0){
        if(diff_minutes == 1){
            $('#seconds').html(diff_seconds+' second');
        } else {
            $('#seconds').html(diff_seconds+' seconds');
        }
    }
    
    setTimeout("countdown();", 1000);
}