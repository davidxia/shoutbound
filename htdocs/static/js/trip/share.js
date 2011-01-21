Share = {};

Share.showShareDialog = function() {
    var postData = {
        tripid: Constants.Trip['id'],
    };
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_panel_share_trip',
       data: postData,
       success: Share.displayShareDialog
    });
}

Share.displayShareDialog = function(responseString) {
    var response = $.parseJSON(responseString);
    $("#div_to_popup").empty();
    $("#div_to_popup").append(response["data"]);
    $("#div_to_popup").bPopup();
    
    Share.bindButtons();
}

Share.bindButtons = function(){
    $('#trip-share-confirm').bind('click', Share.confirmShare);
    $('#trip-share-cancel').bind('click', Share.hideShareDialog); 
    
    $('.friend-capsule').bind('click', function(){
        
        var uid = $(this).attr('uid');
        
        if($.data(this, 'selected')){
            $(this).removeClass('share-selected');
            $.data(this, 'selected', false);
        } else {
            $(this).addClass('share-selected');
            $.data(this, 'selected', true);
        }
    })   
}

Share.confirmShare = function(){
    var selectedUids = [];
    $('.friend-capsule').each(function(){
        if($.data(this, 'selected')){
            selectedUids.push($(this).attr('uid'));
        }
    });
    
    
    Share.sendShareData(selectedUids);
    
    $("#div_to_popup").bPopup().close();
}

Share.hideShareDialog = function(){
    $("#div_to_popup").bPopup().close();
}

Share.sendShareData = function(uids){
    var postData = {
        tripid: Constants.Trip['id'],
        uids: $.JSON.encode(uids),
        message: $("#trip-share-textarea").val()
    };
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_share_trip',
       data: postData,
       success: Share.displaySuccessDialog
    });
}

Share.displaySuccessDialog = function(responseString) {
    var response = $.parseJSON(responseString);
    $("#div_to_popup").empty();
    $("#div_to_popup").append(response["data"]);
    $("#div_to_popup").bPopup();
    
    $('.nn-success').bind('click', Share.hideShareDialog); 
}