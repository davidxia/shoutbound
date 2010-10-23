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

        //text += '<div class="marker">';

        // image and rating
        //text += '<img class="businessimage" src="'+biz.photo_url+'"/>';

        // div start
        //text += '<div class="businessinfo" style="margin-left:60px; margin-top:2px">';
        // name/url
        //text += '<a href="'+biz.url+'" target="_blank">'+biz.name+'</a><br/>';
        /// stars
        //text += '<img class="ratingsimage" src="'+biz.rating_img_url_small+'"/><br/>'

        //if(biz.address1.length)
          //  text += biz.address1 + '<br/>';
        // address2
        //if(biz.address2.length) 
          //  text += biz.address2+ '<br/>';
        // city, state and zip
        //text += biz.city + ',&nbsp;' + biz.state + '&nbsp;' + biz.zip + '<br/>';
        // phone number
        //if(biz.phone.length)
          ///  text += formatPhoneNumber(biz.phone);
        // Read the reviews
        ///text+='<br>';
        //text += '<br/><a href="'+biz.url+'" target="_blank">Read the reviews »</a><br/>';
        // div end

        //text += '</div></div>';

        //text += '<div class="clear-both"></div>';

        return text;
    
    
}

WallUtil.generateNewWallItemHtml = function(fid, name, body){
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
    text += '"'+body+'"';
    text += '</span>';
    
    text += '</div>';
    
    text += '<div class="clear-both"></div>';
    
    text += '</div>';
    
    return text;
}

WallUtil.asyncAddActiveWallItem = function(responseText){
    var response = $.parseJSON(responseText);
    var commentContent = WallUtil.generateNewWallItemHtml(response.fid, response.name, response.body);
    //var commentItem = document
    
    $(commentContent).prependTo('#trip-wall-items').fadeIn('slow');
    
}