Wall = {
    
    loadWall: function() {
        // bind post function to wall post button
        $('#submit-wall').click(function() {
            $.ajax({
                type: 'POST',
                url: baseUrl + 'trip/wall_post',
                data: {
                    tripid: tripid,
                    body: $('#wall-text-input').val()
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
                            replyid: replyid
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
                    $('#wall-item-'+response.itemid).remove();
                    $('#replies_'+response.itemid).next().remove();
                    $('#replies_'+response.itemid).remove();
                    //Wall.removeWallReplies(response.itemid);
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
        
        commentHTML += '<br/><span class="wall-timestamp">show elapsed time</span><br/>';
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
    }
    
};

$(document).ready(Wall.loadWall);