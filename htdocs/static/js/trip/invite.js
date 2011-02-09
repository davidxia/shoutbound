Invite = {
    
    showInviteDialog: function() {
        var postData = {
            tripid: tripid
        };

        $.ajax({
           type: 'POST',
           url: baseUrl + 'trip/ajax_panel_invite_trip',
           data: postData,
           success: Invite.displayInviteDialog
        });

    },
    
    displayInviteDialog: function(responseString) {
        var response = $.parseJSON(responseString);
        $("#div_to_popup").empty();
        $("#div_to_popup").append(response["data"]);
        $("#div_to_popup").bPopup();

        Invite.bindButtons();
    },
    
    bindButtons: function(){
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

    },
    
    hideInviteDialog: function(){
        $("#div_to_popup").bPopup().close();
    },
    
    confirmInvite: function(){
        var selectedUids = [];
        $('.friend-capsule').each(function(){
            if($.data(this, 'selected')){
                selectedUids.push($(this).attr('uid'));
            }
        });

        Invite.sendInviteData(selectedUids);
        $("#div_to_popup").bPopup().close();
    },
    
    sendInviteData: function(uids){
        var postData = {
            tripid: tripid,
            uids: $.JSON.encode(uids),
            message: $("#trip-invite-textarea").val()
        };

        $.ajax({
           type:'POST',
           url: baseUrl + 'trip/ajax_invite_trip',
           data: postData,
           success: Invite.displaySuccessDialog
        });
    },
    
    displaySuccessDialog: function(responseString) {
        var response = $.parseJSON(responseString);
        $("#div_to_popup").empty();
        $("#div_to_popup").append(response["data"]);
        $("#div_to_popup").bPopup();

        $('.success').bind('click', Invite.hideInviteDialog); 
    },
    
    joinTrip: function(uid){
        var postData = {
            tripid: tripid,
            uid: uid
        }
    
        $.ajax({
            type:'POST',
            url: baseUrl + 'trip/ajax_join_trip',
            data: postData,
            success: function(response){
                //var r = $.parseJSON(response);
                //alert(r['success']);
                if($.parseJSON(response)){
                    $('#rsvp_status').html("I'm in");
                    $('#rsvp_button').html('<a href="#" onclick="Invite.leaveTrip('+uid+');">I\'m lame and can\'t go :(</a><br/>');
                }
            }
        });
    },
    
    leaveTrip: function(uid){
        var postData = {
            tripid: tripid,
            uid: uid
        }
    
        $.ajax({
            type:'POST',
            url: baseUrl + 'trip/ajax_leave_trip',
            data: postData,
            success: function(response){
                //var r = $.parseJSON(response);
                //alert(r['success']);
                if($.parseJSON(response)){
                    $('#rsvp_status').html("I'm lame");
                    $('#rsvp_button').html('<a href="#" onclick="Invite.joinTrip('+uid+');">Count me in</a><br/>');
                }
            }
        });
    }
    
};