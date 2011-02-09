Wall = {

    // these global variables help convert post timestamps
    // current datetime
    currentDateTime: new Date(),
    // array to map month numbers to names
    monthNames: new Array("January", "February", "March",
        "April", "May", "June", "July", "August", "September",
        "October", "November", "December"),
    // array to map day of the week to names
    dayNames: new Array("Sunday", "Monday", "Tuesday", "Wednesday",
                        "Thursday", "Friday", "Saturday"),

    
    loadWall: function() {
        // bind post function to wall post button
        $('#submit-wall').click(function() {
            $.ajax({
                type: 'POST',
                url: baseUrl + 'trip/wall_post',
                data: {
                    tripid: tripid,
                    body: $('#wall-text-input').val(),
                    created: Math.round(new Date().getTime()/1000)
                },
                success: Wall.showPost
            });
        });
        
        
        $('.show_reply_button').click(function() {
            var replyid = $(this).attr('postid');
            
            $(this).parent().append('<textarea class="reply_box" id="reply_box_'+replyid+'"></textarea>'+
                '<div class="reply-container">' +
                '<button class="reply_submit" parentid="'+replyid+'">reply</button>' +
                '</div>');
            $(this).hide();
            $('#reply_box_'+replyid).focus();

            $('.reply_submit[parentid="'+replyid+'"]').click(function() {
                // if the reply box isn't empty
                if($('#reply_box_'+replyid).val()){
                    // then posts the reply
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + 'trip/wall_post',
                        data: {
                            tripid: tripid,
                            body: $('#reply_box_'+replyid).val(),
                            replyid: replyid,
                            created: Math.round(new Date().getTime()/1000)
                        },
                        success: Wall.showPost
                    });

                    $('.show_reply_button[postid="'+replyid+'"]').show();
                }
                $('#reply_box_'+replyid).remove();
                $(this).remove();
                $('.show_reply_button').show();
            });
            return false;
        });
        
        $('.remove-wall-item').click(function(){
            var itemid = $(this).attr('itemid');
            
            $.ajax({
                type: 'POST',
                url: baseUrl + 'trip/remove_trip_item',
                data: {
                    tripid: tripid,
                    itemid: itemid
                },
                success: function(responseText){
                    var response = $.parseJSON(responseText);
                    $('#wall-item-'+response.itemid).fadeOut(1000);
                    $('#replies_'+response.itemid).next().fadeOut(1000);
                    $('#replies_'+response.itemid).fadeOut(1000);
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + 'trip/remove_wall_replies',
                        data: {
                            tripid: tripid,
                            replyid: response.itemid
                        }
                    });
                }
            });
        });
    },
    

    showPost: function(responseText){
        var response = $.parseJSON(responseText);
        
        // display: none creates sliding effect when comment is posted
        if(response.replyid == 0) {
            var commentHTML = '<div id="wall-item-'+response.itemid+'" class="wall-item" style="display:none">';
        } else {
            var commentHTML = '<div class="wall-comment wall-reply" style="display:none">';
        }
        commentHTML += '<div class="nn-fb-img left">';
        commentHTML += '<img class="square-50" src="http://graph.facebook.com/'+response.fid+'/picture?type=square"/>';
        commentHTML += '</div>';

        commentHTML += '<span class="wall-comment-username">'+response.name+'</span>';
        commentHTML += '<span class="wall-comment-text">'+response.body+'</span>';
        
        commentHTML += '<br/><span class="wall-timestamp">a second ago</span><br/>';
        commentHTML += '<div class="clear"></div>';
        commentHTML += '</div>';

        if(response.replyid == 0) {
            commentHTML += '<div id="replies_'+response.itemid+'"></div>';
            commentHTML += '<div class="reply-box"><a href="#" class="show_reply_button" postid="'+response.itemid+'" style="display: inline;">this reply button doesnt work!</a>';
            commentHTML += '<div class="reply-container"></div></div>';
        }
        

        if(response.replyid == 0) {
            $(commentHTML).prependTo('#trip-wall-content').slideDown('slow');
        } else {
            $(commentHTML).appendTo('#replies_'+response.replyid).slideDown('slow');
        }
        
        if(response.replyid == 0)
            $('#wall-text-input').val('');
    },
    
    
    convertPostTimes: function(){
        $('span.wall-timestamp').html(function(){
            var timestamp = "";
            var unixTime = $(this).html();
            
            var datetime = new Date(unixTime*1000-new Date().getTimezoneOffset()+1000);
            var year = datetime.getFullYear();
            var month = datetime.getMonth();
            var date = datetime.getDate();
            var day = datetime.getDay();
            var hour = datetime.getHours();
            var minute = datetime.getMinutes();
            var second = datetime.getSeconds();
                    
            if((Wall.currentDateTime.getFullYear() - year) > 0){
                timestamp = Wall.monthNames[month]+' '+date+', '+year+' at '+hour+':'+minute;
            } else if((Wall.currentDateTime.getMonth() - month) > 0 || (Wall.currentDateTime.getDate() - date) > 7){
                timestamp = Wall.monthNames[month]+' '+date+' at '+hour+':'+minute;
            } else if((Wall.currentDateTime.getDate() - date) > 0){
                timestamp = Wall.dayNames[day]+' at '+hour+':'+minute;
            } else if((Wall.currentDateTime.getHours() - hour) > 1){
                timestamp = (Wall.currentDateTime.getHours() - hour)+' hours ago';
            } else if((Wall.currentDateTime.getHours() - hour) == 1){
                timestamp = '1 hour ago';
            } else if((Wall.currentDateTime.getMinutes() - minute) > 1){
                timestamp = (Wall.currentDateTime.getMinutes() - minute)+' minutes ago';
            } else if((Wall.currentDateTime.getMinutes() - minute) == 1){
                timestamp = '1 minute ago';
            } else {
                timestamp = (Wall.currentDateTime.getSeconds() - second)+' seconds ago';
            }
        
            return timestamp;
        });
    }
    
};

$(document).ready(Wall.loadWall);
$(document).ready(Wall.convertPostTimes);