Wall = {
    
    asyncAddActiveWallItem: function(responseText, isSuccess, request){
        console.log(responseText);
        console.log(isSuccess);
        console.log(request);
        
        var response = $.parseJSON(responseText);

        var commentContent = Wall.generateNewWallItemHtml(response.fid, response.name, response.body, false);
        console.log(commentContent);

        $(commentContent).prependTo('#trip-wall-content').slideDown('slow');
        $('#wall-text-input').val('');
    },
    
    generateNewWallItemHtml: function(fid, name, body, isLocation, isReply){
        var text = '';
        text += '<div class="wall-comment"';
        //if(isReply)
            //text += ' wall-reply';
        text += ' style="display:none">';// creates sliding effect when comment is posted
        text += '<div class="nn-fb-img left">';

        text += '<img class="square-50" src="http://graph.facebook.com/';
        text += fid;
        text += '/picture?type=square"';
        text += '/></div>';

        text += '<span class="wall-comment-username">';
        text += name;
        text += '</span>';

        text += '<span class="wall-comment-text">';
        text += body;

        text += '</span>';

        text += '<div class="clear"></div>';

        text += '</div>';

        return text;
    }
    
    /*
    generateWallItemHtml: function(biz){
        Trip.activeTripItem = biz;
        var text = '&nbsp<a href="'+biz.url+'" target="_blank">'+biz.name+'</a>';
        return text;
    }
    */
};