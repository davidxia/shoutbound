var share = {};


$(function() {
  $('#follow').live('click', function() {
    share.saveRsvp(3);
    return false;
  });
  
  $('#unfollow').live('click', function() {
    share.saveRsvp(0);
    return false;
  });
  
  $('#rsvp_yes_button').live('click', function() {
    var loggedin = loginSignup.getStatus();
    if (loggedin) {
      share.saveRsvp(9);
    } else {
      loginSignup.showDialog('rsvp', 3);
    }
    return false;
  });
  
  $('#rsvp_no_button').live('click', function() {
    var loggedin = loginSignup.getStatus();
    if (loggedin) {
      share.saveRsvp(0);
    } else {
      loginSignup.showDialog('rsvp', 0);
    }
    return false;
  });
});


share.saveRsvp = function(rsvp) {  
  $.post(baseUrl+'trips/ajax_save_rsvp', {tripId:tripId, rsvp:rsvp},
    function(r) {
      var r = $.parseJSON(r);
      console.log(r);
    });
};

/*
share.rsvpSuccess = function(r) {
  if (r.rsvp == 3) {
    // unbind click event
    $('#rsvp_yes_button').unbind();
    // change rsvp status
    // fade in avatar
    var html = '<div class="trip_goer" style="display:none;" uid="'+r.userId+'"><a href="'+baseUrl+'profile/'+r.userId+'"><img src="'+staticSub+'profile_pics/'+r.profilePic+'" height="30" width="30"></a></div>';
    $(html).insertAfter('#num_trip_goers').fadeIn('slow');
    // increase number by one
    $('#num').html(function() {
      if (parseInt($(this).html()) == 1) {
        $('#num_trip_goers').html('<span id="num">2</span> people are going.');
      } else if (parseInt($(this).html()) == 0) {
        $('#num_trip_goers').html('<span id="num">1</span> person is going.');
      } else {
        return parseInt($(this).html())+1;
      }
    })
    // fade out then remove yes button, replace with no button, and bind with click
    $('#rsvp_yes_button').fadeOut(300, function() {
      $(this).remove();
      $('div.console').empty().html('Get advice, ideas and recommendations for this trip by <a href="#" id="share">Sharing</a> it with other people. You can also <a href="#" id="invite-others-button">Invite</a>  other people to join you this trip. ');
      $('#rsvp_buttons').empty();//.append('<a href="#" id="rsvp_no_button">I\'m out</a>');
      //$('#rsvp_no_button').click(function() {
        //share.rsvpNo();
        //return false;
      //});
    });
    $('#countdown-container').remove();
  } else {
    // unbind click event
    $('#rsvp_no_button').unbind();
    // change rsvp status
    // remove invite and ask for suggestions button
    $('#invsugg_btn_cont').remove();
    // fade out avatar then remove
    $('div[uid="'+r.userId+'"]').fadeOut('slow', function(){
      $(this).remove();
    });
    // decrease number by one
    $('#num').html(function(){
      if (parseInt($(this).html()) == 2) {
        $('#num_trip_goers').html('<span id="num">1</span> people are going.');
      } else if (parseInt($(this).html()) == 1) {
        $('#num_trip_goers').html('<span id="num">0</span> person is going.');
      } else {
        return parseInt($(this).html())-1;
      }
    })
    // fade out no button, remove, and replace with yes button, bind with click
    $('#rsvp_no_button').fadeOut(300, function(){
      $(this).remove();
      //$('#rsvp_buttons').removeClass('moved');
      $('#rsvp_buttons').empty().append('<a href="#" id="rsvp_yes_button">I\'m in</a>');
      $('#rsvp_yes_button').click(function() {
        share.rsvpYes();
        return false;
      });
    });
  }
};
*/
    
share.showShareDialog = function(shareRole) {
  $.ajax({
    type: 'POST',
    url: baseUrl+'trip_shares/ajax_trip_share_dialog',
    data: {tripId:tripId, shareRole:shareRole},
    success: function(response) {
      var r = $.parseJSON(response);
      $('#div-to-popup').empty().append(r.data).bPopup({follow:false, opacity:0});
      share.bindButtons(shareRole);
    }
  });
};
  
  
share.bindButtons = function(shareRole) {
  $('#shoutbound-share').bind('click', share.FriendSelector);
  $('#facebook-share').click(function() {
    share.facebookShare(shareRole);
    return false;
  });
  $('#twitter-share').click(function() {
    share.tweet(shareRole);
    return false;
  });
  $('#email-share').click(function() {
    share.emailShare();
    return false;
  });

  $('#trip-share-confirm').click(function() {
    share.confirmShare(shareRole);
    return false;
  });
  $('#trip-share-cancel').click(function() {
    $('#div-to-popup').bPopup().close();
    return false;
  });

  $('.friend-capsule').bind('click', function() {
    if ($.data(this, 'selected')) {
      $(this).removeClass('share-selected');
      $.data(this, 'selected', false);
    } else {
      $(this).addClass('share-selected');
      $.data(this, 'selected', true);
    }
    return false;
  });
};


share.FriendSelector = function() {
  $('#friends').toggle();
  $('#share-methods').toggle();
  $('#trip-share-toolbar').toggle();
  return false;
};
  

share.facebookShare = function(shareRole) {
  var shareKey = share.generateShareKey(shareRole, 2, 'fb');
  var url = 'http://www.facebook.com/sharer.php?u='+baseUrl+'trips/share/'+tripId+'/'+shareKey;
  var window_specs = 'toolbar=0, status=0, width=626, height=436';
  
  var x = Math.ceil((window.screen.availHeight/2)-100);
  var y = Math.ceil(150);
  var popup = window.open(url, '_blank', window_specs);
  popup.moveTo(x,y);
  
  $('#div-to-popup').bPopup().close();
  return false;
};


share.tweet = function(shareRole) {
  var shareKey = share.generateShareKey(shareRole, 2, 'tw');
  if (shareRole == 2) {
    var message = 'Come with me on this trip I\'m planning: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
  } else if (shareRole == 1) {
    var message = 'Help me plan my trip: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
  }
  message = encodeURIComponent(encodeURIComponent(message));
  
  var url = 'http://twitter.com/login?redirect_after_login=%2Fhome%3Fstatus%3D'+message;
  window.open(url);
  
  $('#div-to-popup').bPopup().close();
  return false;
};


share.emailShare = function() {
  $('#share-methods').toggle();
  $('#email-input').toggle();
  $('#trip-share-toolbar').toggle();
};


share.confirmShare = function(shareRole) {  
  var uids = [];
  $('.friend-capsule').each(function() {
    if ($.data(this, 'selected')) {
      uids.push($(this).attr('uid'));
    }
  });
  uids = $.JSON.encode(uids);

  if ($('#emails').val())
  {
    var postData = {
      tripId: tripId,
      emails: $('#emails').val(),
      shareRole: shareRole
    };
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'trip_shares/send_email',
      data: postData,
      success: function(r) {
        share.displaySuccessDialog(r);
      }
    });
  } else {
    var postData = {
      tripId: tripId,
      uids: uids,
      shareRole: shareRole
    };
  
    $.ajax({
      type: 'POST',
      url: baseUrl+'trip_shares/ajax_share_trip',
      data: postData,
      success: function(r) {
        share.displaySuccessDialog(r);
        share.sendEmail(uids, shareRole);
      }
    });
  }
    
  $('#div-to-popup').bPopup().close();
  return false;
};


share.displaySuccessDialog = function(r) {
  $('#div-to-popup').empty();
  $('#div-to-popup').append(r);
  $('#div-to-popup').bPopup();
  $('.success').click(function() {
    $('#div-to-popup').bPopup().close();
  });  
};


share.sendEmail = function(uids, shareRole) {
  $.ajax({
    type: 'POST',
    url: baseUrl+'trip_shares/send_email',
    data: {tripId:tripId, uids:uids, shareRole:shareRole},
  });
};


share.generateShareKey = function(shareRole, shareMedium, targetId) {
  var postData = {
    tripId: tripId,
    shareRole: shareRole,
    shareMedium: shareMedium,
    targetId: targetId,
    isClaimed: -1
  };
  
  var r = '';
  $.ajax({
    async: false,
    type: 'POST',
    url: baseUrl+'trip_shares/ajax_generate_share_key',
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
};


$(function() {
  $('#invite-others-button').live('click', function() {
    share.showShareDialog(5);
    return false;
  });
  $('#share').live('click', function() {
    share.showShareDialog(0);
    return false;
  });
});