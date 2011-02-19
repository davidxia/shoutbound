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
    
    ajax_rsvp_yes: function(){
        var post_data = {
            tripid: tripid,
            uid: uid
        }
    
        $.ajax({
            type:'POST',
            url: baseUrl + 'trip/ajax_rsvp_yes',
            data: post_data,
            success: function(response){
                if($.parseJSON(response)['success']){
                    // unbind click event
                    $('#rsvp_yes_button').unbind();
                    // change rsvp status
                    $('#rsvp_status').html("You're in :)");
                    // fade in avatar
                    var html = '<div class="trip_goer" style="display:none" uid="'+uid+'"><img class="square-50" src="http://graph.facebook.com/'+fid+'/picture?type=square"></div>';
                    $(html).prependTo('#trip_goers').fadeIn('slow');
                    // increase number by one
                    $('#num').html(function(){
                        return parseInt($(this).html())+1;
                    })
                    // fade out then remove yes button, replace with no button, and bind with click
                    $('#rsvp_yes_button').fadeOut(300, function(){
                        $(this).remove();
                        $('#rsvp_buttons').addClass('moved');
                        $('#rsvp_buttons').append('<a href="#" id="rsvp_no_button">I\'m out</a>').click(function(){
                            Invite.ajax_rsvp_no();
                        });
                    });
                    $('#rsvp_status').after('<div id="invsugg_btn_cont"><div id="invite_others_button">invite other people</div><div id="get_suggestions_button">get more suggestions</div></div>');
                }
            }
        });
    },
    
    
    ajax_rsvp_no: function(){
        var post_data = {
            tripid: tripid,
            uid: uid
        }
    
        $.ajax({
            type:'POST',
            url: baseUrl + 'trip/ajax_rsvp_no',
            data: post_data,
            success: function(response){
                if($.parseJSON(response)['success']){
                    // unbind click event
                    $('#rsvp_no_button').unbind();
                    // change rsvp status
                    $('#rsvp_status').html("You're out, but you can still change your mind.");
                    // remove invite and ask for suggestions button
                    $('#invsugg_btn_cont').remove();
                    // fade out avatar then remove
                    $('div[uid="'+uid+'"]').fadeOut('slow', function(){
                        $(this).remove();
                    });
                    // decrease number by one
                    $('#num').html(function(){
                        return parseInt($(this).html())-1;
                    })
                    // fade out no button, remove, and replace with yes button, bind with click
                    $('#rsvp_no_button').fadeOut(300, function(){
                        $(this).remove();
                        $('#rsvp_buttons').removeClass('moved');
                        $('#rsvp_buttons').append('<a href="#" id="rsvp_yes_button">I\'m in</a>').click(function(){
                            Invite.ajax_rsvp_yes();
                        });
                    });
                }
            }
        });
    }
    
};

Invite.ajax_create_trip_goers_html = function(){
    var html = '<div class="trip_goer">';
    html += '<img class="square-50" src="http://graph.facebook.com/'+fid+'/picture?type=square">';
    html += '</div>';
    return html;
}


$(document).ready(function(){
    $('#rsvp_yes_button').click(function() {
        Invite.ajax_rsvp_yes();
        return false;
    });
    $('#rsvp_no_button').click(function() {
        Invite.ajax_rsvp_no();
        return false;
    });
});