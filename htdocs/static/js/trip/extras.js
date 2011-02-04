function saveTripDate(){
    var tripStartYear = $('#trip-start-year').val();
    var tripStartMonth = $('#trip-start-month').val();
    var tripStartDay = $('#trip-start-day').val();
    var tripStartHour = parseInt($('#trip-start-hour').val())
        +new Date().getTimezoneOffset()/60;
    var tripStartMinute = $('#trip-start-minute').val();
    
    switch(tripStartMonth){
        case "January": tripStartMonth = 0; break;
        case "February": tripStartMonth = 1; break;
        case "March": tripStartMonth = 2; break;
        case "April": tripStartMonth = 3; break;
        case "May": tripStartMonth = 4; break;
        case "June": tripStartMonth = 5; break;
        case "July": tripStartMonth = 6; break;
        case "August": tripStartMonth = 7; break;
        case "September": tripStartMonth = 8; break;
        case "October": tripStartMonth = 9; break;
        case "November": tripStartMonth = 10; break;
        case "December": tripStartMonth = 11; break;
        default: tripStartMonth = 0;
    }
    
    var tripUnixTime = Date.UTC(tripStartYear, tripStartMonth,
                                tripStartDay, tripStartHour,
                                tripStartMinute)/1000;
    var postData = {
        tripid: tripid,
        tripStartDate: tripUnixTime
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
    // Get # seconds diff btw trip start date's Unix time and current Unix time
    var current = Math.round(new Date().getTime()/1000.0);
    var diff_seconds = tripStartDate - current;
    
    // if trip's start date passed, display a message instead of countdown timer
    if(diff_seconds >= 0 ){
        //Number of years left
        var diff_years = Math.floor(diff_seconds/(60*60*24*365.25));
        diff_seconds -= diff_years * 60 * 60 * 24 * 365.25;
        if(diff_years > 0){
            if(diff_years == 1){
                $('#years').html(diff_years+' year');
            } else {
                $('#years').html(diff_years+' years');
            }
        }
    
        //Number of days left
        var diff_days = Math.floor(diff_seconds/(60*60*24));
        diff_seconds -= diff_days * 60 * 60 * 24;
        if(diff_days > 0){
            if(diff_days == 1){
                $('#days').html(diff_days+' day');
            } else {
                $('#days').html(diff_days+' days');
            }
        }

        //Number of hours left
        var diff_hours = Math.floor(diff_seconds/(60*60));
        diff_seconds -= diff_hours * 60 * 60;
        if(diff_hours > 0){
            if(diff_hours == 1){
                $('#hours').html(diff_hours+' hour');
            } else {
                $('#hours').html(diff_hours+' hours');
            }
        }

        //Number of minutes left
        var diff_minutes = Math.floor(diff_seconds/(60));
        diff_seconds -= diff_minutes * 60;
        if(diff_minutes > 0){
            if(diff_minutes == 1){
                $('#minutes').html(diff_minutes+' minute and');
            } else {
                $('#minutes').html(diff_minutes+' minutes and');
            }
        } else {
            $('#minutes').html('');
        }
        //Number of seconds left
        if(diff_seconds > 0){
            if(diff_seconds == 1){
                $('#seconds').html(diff_seconds+' second left');
            } else {
                $('#seconds').html(diff_seconds+' seconds left');
            }
        } else {
            $('#seconds').html('');
        } 
    
        setTimeout("countdown();", 1000);
    } else {
        $('#years').html('Hope you didn\'t chew your arm off!');
    }
}

function convertUnixTime(){
    var datetime = new Date(tripStartDate*1000-new Date().getTimezoneOffset()+1000);
    var year = datetime.getFullYear();
    var month = datetime.getMonth()+1;
    var day = datetime.getDate();
    var hour = datetime.getHours();
    var minute = datetime.getMinutes();
    var second = datetime.getSeconds();
    
    $('#trip-local-start-date').html(month+'/'+day+'/'+year+' '+hour+':'+minute+':'+second);
}