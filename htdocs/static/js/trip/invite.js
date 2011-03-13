var invite = {};

invite.rsvp_yes = function() {
  var post_data = {
    tripId: tripId,
    uid: uid
  };

  $.ajax({
    type: 'POST',
    url: baseUrl+'trips/ajax_rsvp_yes',
    data: post_data,
    success: function(response) {
      if ($.parseJSON(response)['success']) {
        // unbind click event
        $('#rsvp_yes_button').unbind();
        // change rsvp status
        $('#rsvp_status').html("You're in :)");
        // fade in avatar
        var html = '<div class="trip_goer" style="display:none; float:left; margin-right:10px;" uid="'+uid+'"><img style="height:50px;width:50px;" src="http://graph.facebook.com/'+fid+'/picture?type=square"></div>';
        $(html).prependTo('#trip_goers').fadeIn('slow');
        // increase number by one
        $('#num').html(function(){
          return parseInt($(this).html())+1;
        })
        // fade out then remove yes button, replace with no button, and bind with click
        $('#rsvp_yes_button').fadeOut(300, function() {
          $(this).remove();
          $('#rsvp_buttons').addClass('moved');
          $('#rsvp_buttons').append('<a href="#" id="rsvp_no_button">I\'m out</a>');
          $('#rsvp_no_button').click(function() {
            invite.rsvp_no();
            return false;
          });
        });
        $('#rsvp_status').after('<div id="invsugg_btn_cont"><div id="invite-others-button"><a href="#" id="invite-others-link">invite other people</a></div><div id="get_suggestions_button"><a href="#" id="get-suggestions-link">get more suggestions</a></div></div>');
      }
    }
  });
}


invite.rsvp_no = function() {
  var post_data = {
    tripId: tripId,
    uid: uid
  };

  $.ajax({
    type: 'POST',
    url: baseUrl+'trips/ajax_rsvp_no',
    data: post_data,
    success: function(response) {
      if ($.parseJSON(response)['success']) {
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
          $('#rsvp_buttons').append('<a href="#" id="rsvp_yes_button">I\'m in</a>');
          $('#rsvp_yes_button').click(function() {
            invite.rsvp_yes();
            return false;
          });
        });
      }
    }
  });
}

    
invite.showInviteDialog = function() {
  var postData = {tripId: tripId};
  $.ajax({
    type: 'POST',
    url: baseUrl+'trips/ajax_trip_invite_panel',
    data: postData,
    success: function(response) {
      var r = $.parseJSON(response);
      $('#div-to-popup').empty().append(r.data).bPopup({follow:false});
      invite.bindButtons();
    }
  });
}
  
  
invite.bindButtons = function() {
  $('#trip-invite-confirm').bind('click', invite.confirmInvite);
  $('#trip-invite-cancel').bind('click', function() {
    $('#div-to-popup').bPopup().close();
    return false;
  });

  $('.friend-capsule').bind('click', function() {
    // different behavior based on whether it's a fb friend or sb friend, etc
    var attr = $(this).attr('sbid');
    if (typeof attr !== 'undefined' && attr !== false) {
      if ($.data(this, 'sb-sel')) {
        $(this).removeClass('share-selected');
        $.data(this, 'sb-sel', false);
      } else {
        $(this).addClass('share-selected');
        $.data(this, 'sb-sel', true);
      }
    }
    
    attr = $(this).attr('fbid');
    if (typeof attr !== 'undefined' && attr !== false) {
      if ($.data(this, 'fb-sel')) {
        $(this).removeClass('share-selected');
        $.data(this, 'fb-sel', false);
      } else {
        $(this).addClass('share-selected');
        $.data(this, 'fb-sel', true);
      }
    }
    return false;
  });
}
  
  
invite.confirmInvite = function() {
  var selectedFBids = [];
  $('.friend-capsule').each(function() {
    if ($.data(this, 'fb-sel')) {
      selectedFBids.push($(this).attr('fbid'));
    }
  });
  
  var selectedSBids = [];
  $('.friend-capsule').each(function() {
    if ($.data(this, 'sb-sel')) {
      selectedSBids.push($(this).attr('sbid'));
    }
  });

  if (selectedFBids.length >= 1) {
    invite.sendFBMessage(selectedFBids);
  }
  if (selectedSBids.length >= 1) {
    invite.sendSBInvite(selectedSBids);
  }
  $('#div-to-popup').bPopup().close();
  return false;
}


// opens new window for Facebook private message
// TODO: how to send to multiple recipients?
invite.sendFBMessage = function(selectedFBids) {
  var to = selectedFBids[0];
  var shareKey = invite.generateShareKey('fbid '+to);
  var message = 'Come with me on this trip I\'m planning: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
  var url = 'http://www.facebook.com/messages/'+to+'?msg_prefill='+message;
  window.open(url);
}


invite.generateShareKey = function(targetId) {
  var postData = {
    tripId: tripId,
    shareRole: 2,
    shareMedium: 1,
    targetId: targetId
  };
  
  var r = '';
  $.ajax({
    async: false,
    type: 'POST',
    url: baseUrl+'trip_shares/generate_share_key',
    data: postData,
    success: function(response) {
      r = $.parseJSON(response);
    }
  });
  
  if (r.success) {
    return r.shareKey;
  } else {
    alert(r.message);
  }
}


// add record to trips_users and sends email via Sendgrid
invite.sendSBInvite = function(uids) {
  var postData = {
    tripId: tripId,
    uids: $.JSON.encode(uids),
    message: $('#trip-invite-textarea').val()
  };

  $.ajax({
    type: 'POST',
    url: baseUrl+'trips/ajax_invite_trip',
    data: postData,
    success: invite.displaySuccessDialog
  });
}


invite.displaySuccessDialog = function(response) {
  var r = $.parseJSON((response));
  $('#div-to-popup').empty();
  $('#div-to-popup').append(r['data']);
  $('#div-to-popup').bPopup();
  $('.success').bind('click', function() {
    $('#div-to-popup').bPopup().close();
  });  
}


$(document).ready(function() {
  $('#rsvp_yes_button').click(function() {
    invite.rsvp_yes();
    return false;
  });
  $('#rsvp_no_button').click(function() {
    invite.rsvp_no();
    return false;
  });
  $('#invite-others-button').click(function() {
    invite.showInviteDialog();
    return false;
  });
});