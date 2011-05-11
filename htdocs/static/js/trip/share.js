var share = {};

$(function() {  
  $('#invite-others-button').live('click', function() {
    share.showShareDialog(5);
    return false;
  });
  $('#share').live('click', function() {
    share.showShareDialog(0);
    return false;
  });

  $('.friend-capsule').live('click', function() {
    if ($.data(this, 'selected')) {
      $(this).removeClass('share-selected');
      $.data(this, 'selected', false);
    } else {
      $(this).addClass('share-selected');
      $.data(this, 'selected', true);
    }
    return false;
  });

  $('#facebook-invite').live('click', function() {
    share.facebookShare(5);
    return false;
  });
  $('#facebook-share').live('click', function() {
    share.facebookShare(0);
    return false;
  });
  $('#twitter-invite').live('click', function() {
    share.tweet(5);
    return false;
  });
  $('#twitter-share').live('click', function() {
    share.tweet(0);
    return false;
  });

  $('#confirm-invite').live('click', function() {
    share.confirmShare(5);
    return false;
  });
  $('#confirm-share').live('click', function() {
    share.confirmShare(0);
    return false;
  });
  $('#invite-cancel').live('click', function() {
    $('#invite-popup').bPopup().close();
    return false;
  });
  $('#share-cancel').live('click', function() {
    $('#share-popup').bPopup().close();
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
    function(d) {
      var r = $.parseJSON(d);
    });
};

    
share.showShareDialog = function(shareRole) {
  var popupType = (shareRole==5) ? 'invite' : 'share';
  var popup = $('#'+popupType+'-popup');
  if (popup.length > 0) {
    popup.bPopup({follow:false, opacity:0});
  } else {
    $.ajax({
      url: baseUrl+'static/js/jquery/popup.js',
      dataType: 'script',
      success: function() {      
        $.post(baseUrl+'trips/ajax_share_dialog', {tripId:tripId, shareRole:shareRole},
          function(d) {
            var r = $.parseJSON(d);
            popup = $('<div class="popup" id="'+popupType+'-popup" style="display:none;"/>');
            $('body').append(popup);
            popup.append(r.data).bPopup({follow:false, opacity:0});
          });
      },
      cache: true
    });
  }
};
  

share.facebookShare = function(shareRole) {
  var shareKey = share.generateShareKey(shareRole, 2, 'fb');
  var url = 'http://www.facebook.com/sharer.php?u='+baseUrl+'trips/share/'+tripId+'/'+shareKey;
  var window_specs = 'toolbar=0, status=0, width=626, height=436';
  
  var x = Math.ceil((window.screen.availHeight/2)-100);
  var y = Math.ceil(150);
  var popup = window.open(url, '_blank', window_specs);
  popup.moveTo(x,y);
  
  var ele = (shareRole == 5) ? 'invite' : 'share';
  $('#'+ele+'-popup').bPopup().close();
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
  
  var ele = (shareRole == 5) ? 'invite' : 'share';
  $('#'+ele+'-popup').bPopup().close();
  return false;
};


share.confirmShare = function(shareRole) {
  var uids = [];
  $('.friend-capsule').each(function() {
    if ($.data(this, 'selected')) {
      uids.push($(this).attr('uid'));
    }
  });

  var validEmail = true;  
  var emails = $('#emails').val();
  if (emails) {
    emails = emails.split(',');
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    $.each(emails, function(i, val) {
      emails[i] = $.trim(val);
      if (emails[i] && !emails[i].match(re)) {
        validEmail = false;
        return false;
      }
    });
    if (!validEmail) {
      $('#email-input').append('<span id="invalid-email">You entered an invalid email address.</span>').delay(5000).queue(function() {$('#invalid-email').remove();});
      emails = '';
    }
  }
  
  if ((uids.length > 0 && validEmail) || (emails && validEmail)) {
    $.post(baseUrl+'trips/ajax_share', {tripId:tripId, shareRole:shareRole, uids:uids, emails:emails},
      function(d) {
        var r = $.parseJSON(d);
        share.showShareSuccess(r.message);
      });
  }
  return false;
};


share.showShareSuccess = function(m) {
  $.post(baseUrl+'trips/ajax_share_success', {message:m},
    function(d) {
      $('.popup').remove();
      var r = $.parseJSON(d);
      var popup = $('<div id="share-success-popup" style="display:none;"/>');
      $('body').append(popup);
      popup.append(r.data).bPopup({follow:false, opacity:0});
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