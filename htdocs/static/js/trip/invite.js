Invite = {};

Invite.showInviteDialog = function() {
    var postData = {
        tripid: Constants.Trip['id'],
    };
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_panel_invite_trip',
       data: postData,
       success: Invite.displayInviteDialog
    });

}


Invite.displayInviteDialog = function(responseString) {
    var response = $.parseJSON(responseString);
    $("#div_to_popup").empty();
    $("#div_to_popup").append(response["data"]);
    $("#div_to_popup").bPopup();
    
    Invite.bindButtons();
}


Invite.bindButtons = function(){
    $('#trip-invite-confirm').bind('click', Invite.confirmInvite);
    $('#trip-invite-cancel').bind('click', Invite.hideInviteDialog); 
    
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


Invite.hideInviteDialog = function(){
    $("#div_to_popup").bPopup().close();
}

Invite.confirmInvite = function(){
    var selectedUids = [];
    $('.friend-capsule').each(function(){
        if($.data(this, 'selected')){
            selectedUids.push($(this).attr('uid'));
        }
    });
    
    Invite.sendInviteData(selectedUids);
    $("#div_to_popup").bPopup().close();
}


Invite.sendInviteData = function(uids){
    var postData = {
        tripid: Constants.Trip['id'],
        uids: $.JSON.encode(uids),
        message: $("#trip-invite-textarea").val()
    };
    
    $.ajax({
       type:'POST',
       url: Constants['siteUrl']+'trip/ajax_invite_trip',
       data: postData,
       success: Invite.displaySuccessDialog
    });
}

Invite.displaySuccessDialog = function(responseString) {
    var response = $.parseJSON(responseString);
    $("#div_to_popup").empty();
    $("#div_to_popup").append(response["data"]);
    $("#div_to_popup").bPopup();
    
    $('.nn-success').bind('click', Invite.hideInviteDialog); 
}