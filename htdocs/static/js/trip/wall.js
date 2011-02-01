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
        
        
        $(".show_reply_button").click(function() {
            var parentid = $(this).attr('postid');
            
            $(this).parent().append('<textarea class="reply_box" id="reply_box_'+parentid+'"></textarea>'+
                '<div class="reply-container">' +
                '<button class="reply_submit" parentid="'+parentid+'">reply</button>' +
                '</div>');
            $(this).hide();
            $('#reply_box_'+parentid).focus();

            $('.reply_submit[parentid="'+parentid+'"]').click(function() {
                $.ajax({
                    type: 'POST',
                    url: baseUrl + 'trip/wall_post',
                    data: {
                        tripid: tripid,
                        body: document.getElementById('reply_box_'+parentid).value,
                        replyid: parentid
                    },
                    success: Wall.showPost
                });

                $('.show_reply_button[postid="'+parentid+'"]').show();
                $('#reply_box_'+parentid).remove();
                $(this).remove();
            });
            return false;
        });        
    },
    

    showPost: function(responseText){
        var response = $.parseJSON(responseText);
        console.log(response);
        
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