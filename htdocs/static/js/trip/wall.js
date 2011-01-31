Wall = {
    
    asyncAddActiveWallItem: function(responseText, isSuccess, request, isLocation){
        var response = $.parseJSON(responseText);
        if(isLocation){
            var commentContent = Wall.generateNewWallLocationHtml(response.fid, response.name, $.parseJSON(response.biz), response.body);
        } else {
            var commentContent = Wall.generateNewWallItemHtml(response.fid, response.name, response.body, false);
        }

        $(commentContent).prependTo('#trip-wall-items').slideDown('slow');
        $('#wall-text-input').val('');
    },
    
    generateNewWallItemHtml: function(fid, name, body, isLocation, isReply){
        var text = '';
        text += '<div class="wall-comment';
        //if(isReply)
            //text += ' wall-reply';
        text += '" style="display:none">';
        text += '<div class="nn-fb-img left">';

        text += '<img class="square-50" src="http://graph.facebook.com/';
        text += fid;
        text += '/picture?type=square"';
        text += '/></div>';

        text += '<div class="wall-text left">';

        text += '<span class="wall-comment-username">';
        text += name;
        text += '</span>';

        text += '<span class="wall-comment-text">';
        text += body;

        text += '</span>';

        text += '</div>';

        text += '<div class="clear"></div>';

        text += '</div>';

        return text;
    },
    
    generateWallItemHtml: function(biz){
        Trip.activeTripItem = biz;
        var text = '&nbsp<a href="'+biz.url+'" target="_blank">'+biz.name+'</a>';
        return text;
    },
    
    generateNewWallLocationHtml: function(fid, name, biz, body){
        var bodyText = Wall.generateWallItemHtml(biz);
        bodyText = 'suggested' + '<span class="wall-location-text">'+bodyText+'</span>';

        if(body){
            bodyText +='<br/><br/>'+'"'+body+'"<br/>';
        }

        return Wall.generateNewWallItemHtml(fid, name, bodyText, true, false);
    }
    
};