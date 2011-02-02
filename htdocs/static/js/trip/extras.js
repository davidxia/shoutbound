function saveWhen(){
    var tripWhenYear = $('#trip-when-year').val();
    var tripWhenMonth = $('#trip-when-month').val();
    var tripWhenDay = $('#trip-when-day').val();
    var r = /\d{2}/;
    if(!tripWhenDay.match(r))
        tripWhenDay = '0'+tripWhenDay;
    
    switch(tripWhenMonth){
        case "January": tripWhenMonth = "01"; break;
        case "February": tripWhenMonth = "02"; break;
        case "March": tripWhenMonth = "03"; break;
        case "April": tripWhenMonth = "04"; break;
        case "May": tripWhenMonth = "05"; break;
        case "June": tripWhenMonth = "06"; break;
        case "July": tripWhenMonth = "07"; break;
        case "August": tripWhenMonth = "08"; break;
        case "September": tripWhenMonth = "09"; break;
        case "October": tripWhenMonth = "10"; break;
        case "Novemeber": tripWhenMonth = "11"; break;
        case "December": tripWhenMonth = "11"; break;
        default: tripWhenMonth = "01";
    }
    
    var tripWhen = tripWhenYear+'-'+tripWhenMonth+'-'+tripWhenDay+' 00:00:00';
    var postData = {
        tripid: tripid,
        tripWhen: tripWhen
    };
    
    $.ajax({
        type: 'POST',
        url: baseUrl + 'trip/save_when',
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
    expire = parseInt(Date.parse(when)/1000); //End Date
    var now = new Date();
    var current = parseInt(now.getTime()/1000);
    var diff_seconds = expire - current;

    //Number of years left
    var diff_years = parseInt(diff_seconds/(60*60*24*365))
    diff_seconds -= diff_years * 60 * 60 * 24 * 365;
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