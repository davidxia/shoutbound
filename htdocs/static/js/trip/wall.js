// WALL UTILS

WallUtil = {};

WallUtil.updateWall = function(query){
    //console.log(query);
    
    var postData = {
        body: query,
        title: "wall-poast",
        trip_id: Constants.Trip['id'],
        islocation: 0
    };
    
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_add_item',
       data: postData,//Trip.activeTripItem,
       success: WallUtil.asyncAddActiveWallItem
    });
}

WallUtil.generateWallItemHtml = function(biz){

        Trip.activeTripItem = biz;
        
        var text = '&nbsp<a href="'+biz.url+'" target="_blank">'+biz.name+'</a>';
        return text;
    
    
}

WallUtil.generateNewWallLocationHtml = function(fid, name, biz){
    
    var bodyText = WallUtil.generateWallItemHtml(biz);
    bodyText = 'suggested' + '<span class="wall-location-text">'+bodyText+'</span>';
    
    return WallUtil.generateNewWallItemHtml(fid, name, bodyText, true);
}

WallUtil.generateNewWallItemHtml = function(fid, name, body, isLocation){
    var text = '';
    text += '<div class="wall-comment" style="display:none">';
    text += '<div class="nn-fb-img left">';
    
    text += '<img class="square-50" src="http://graph.facebook.com/';
    text += fid;
    text += '/picture?type=square"';
    text += '/></div>';
    
    text +='<div class="wall-text left">';
    
    text +='<span class="wall-comment-username">';
    text += name;
    text += '</span>';
    
    text += '<span class="wall-comment-text">';
    
    if(isLocation){
        text += body;
    } else {
        text += '"'+body+'"';
    }
    
    text += '</span>';
    
    text += '</div>';
    
    text += '<div class="clear-both"></div>';
    
    text += '</div>';
    
    return text;
}

WallUtil.asyncAddActiveWallItem = function(responseText, isSuccess, request, isLocation){
    var response = $.parseJSON(responseText);
    if(isLocation){
        var commentContent = WallUtil.generateNewWallLocationHtml(response.fid, response.name, $.parseJSON(response.biz));
    } else {
        var commentContent = WallUtil.generateNewWallItemHtml(response.fid, response.name, response.body);
    }
    
    $(commentContent).prependTo('#trip-wall-items').slideDown('slow');
}