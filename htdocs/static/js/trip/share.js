var invite = {};

invite.rsvp_yes = function() {
  if (typeof(uid) === 'undefined') {
    alert('you must login to do this');
  }
  else {
    var post_data = {
      tripId: tripId,
      uid: uid
    };
  
    $.ajax({
      type: 'POST',
      url: baseUrl+'trips/ajax_rsvp_yes',
      data: post_data,
      success: function(r) {
        var r = $.parseJSON(r);
        if (r.success) {
          // unbind click event
          $('#rsvp_yes_button').unbind();
          // change rsvp status
          $('#rsvp_status').html("You're going on this trip");
          // fade in avatar
          var html = '<div class="trip_goer" style="display:none; float:left; margin-right:10px;" uid="'+uid+'"><img src="'+staticSub+'profile_pics/'+r.profilePic+'" height="50" width="50"></div>';
          $(html).insertAfter('#num_trip_goers').fadeIn('slow');
          // increase number by one
          $('#num').html(function() {
            if (parseInt($(this).html()) == 1) {
              $('#num_trip_goers').html('<span id="num">2</span> PEOPLE ARE GOING ON THIS TRIP:');
            } else if (parseInt($(this).html()) == 0) {
              $('#num_trip_goers').html('<span id="num">1</span> PERSON IS GOING ON THIS TRIP:');
            } else {
              return parseInt($(this).html())+1;
            }
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
          $('#rsvp_status').after('<div id="invsugg_btn_cont"><div style="margin: 15px 0;"><a href="#" id="invite-others-button" style="float:left; margin-right:10px; ">Invite</a><div style="display:inline-block; font-size:14px; height:30px;">Invite others<br/>to join this trip!</div></div><div style="margin:15px 0;"><a href="#" id="get-suggestions-button" style="display:inline-block; float:left; margin-right:10px;">Share</a><div style="display:inline-block; font-size:14px; height:30px;">Share this trip<br/>with others!</div></div></div>');
          $('#countdown-container').remove();
        }
      }
    });
  }
}


invite.rsvp_no = function() {
  if (typeof(uid) === 'undefined') {
    alert('you must login to do this');
  }
  else {
    var post_data = {
      tripId: tripId,
      uid: uid
    };
  
    $.ajax({
      type: 'POST',
      url: baseUrl+'trips/ajax_rsvp_no',
      data: post_data,
      success: function(r) {
        if ($.parseJSON(r)['success']) {
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
            if (parseInt($(this).html()) == 2) {
              $('#num_trip_goers').html('<span id="num">1</span> PERSON IS GOING ON THIS TRIP:');
            } else if (parseInt($(this).html()) == 1) {
              $('#num_trip_goers').html('<span id="num">0</span> PEOPLE ARE GOING ON THIS TRIP:');
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
              invite.rsvp_yes();
              return false;
            });
          });
        }
      }
    });
  }
}

    
invite.showShareDialog = function(shareRole) {
  var postData = {
    tripId: tripId,
    shareRole: shareRole
  };
  $.ajax({
    type: 'POST',
    url: baseUrl+'trip_shares/ajax_trip_share_dialog',
    data: postData,
    success: function(response) {
      var r = $.parseJSON(response);
      $('#div-to-popup').empty().append(r.data).bPopup({follow:false, opacity:0});
      invite.bindButtons(shareRole);
    }
  });
}
  
  
invite.bindButtons = function(shareRole) {
  $('#shoutbound-share').bind('click', invite.FriendSelector);
  $('#facebook-share').click(function() {
    invite.facebookMessage(shareRole);
    return false;
  });
  $('#fb-share-wall').click(function() {
    invite.facebookWallPost(shareRole);
    return false;
  });
  $('#twitter-share').click(function() {
    invite.tweet(shareRole);
    return false;
  });
  $('#email-share').click(function() {
    invite.emailShare();
    return false;
  });

  $('#trip-share-confirm').click(function() {
    invite.confirmShare(shareRole);
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
}


invite.FriendSelector = function() {
  $('#friends').toggle();
  $('#share-methods').toggle();
  $('#trip-share-toolbar').toggle();
  return false;
}
  

invite.facebookMessage = function(shareRole) {
  FB.getLoginStatus(function(response) {
    if (response.session) {
      var to = 1;
      var shareKey = invite.generateShareKey(shareRole, 2, 'fb');
      if (shareRole == 2) {
        var message = 'Come with me on this trip I\'m planning: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
      } else if (shareRole == 1) {
        var message = 'Help me plan my trip: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
      }
      
      var url = 'http://www.facebook.com/messages/'+to+'?msg_prefill='+message;
      window.open(url);
    } else {
      FB.login(function(response) {
        if (response.session) {
          var to = 1;
          var shareKey = invite.generateShareKey(shareRole, 2, 'fb');
          if (shareRole == 2) {
            var message = 'Come with me on this trip I\'m planning: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
          } else if (shareRole == 1) {
            var message = 'Help me plan my trip: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
          }
          var url = 'http://www.facebook.com/messages/'+to+'?msg_prefill='+message;
          window.open(url);
        }
      });    
    }
  });
  $('#div-to-popup').bPopup().close();
  return false;
}


invite.facebookWallPost = function(shareRole) {
  FB.getLoginStatus(function(response) {
    if (response.session) {
      var shareKey = invite.generateShareKey(shareRole, 2, 'fb');
      if (shareRole == 2) {
        var message = 'Come with me on this trip I\'m planning.';
      } else if (shareRole == 1) {
        var message = 'Help me plan my trip.';
      }
      FB.ui({
        method: 'feed',
        name: message,
        link: baseUrl+'trips/share/'+tripId+'/'+shareKey,
        picture: baseUrl+'images/sb_logo_75.jpg',
        caption: 'Shoutbound is bi-winning, duh.',
        description: 'David Xia is a god.',
        message: message
      },
      function(r) {
        if (r && r.post_id) {
          $('#div-to-popup').bPopup().close();
        }
      });
    } else {
      FB.login(function(response) {
        if (response.session) {
          var to = 1;
          var shareKey = invite.generateShareKey(shareRole, 2, 'fb');
          if (shareRole == 2) {
            var message = 'Come with me on this trip I\'m planning: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
          } else if (shareRole == 1) {
            var message = 'Help me plan my trip: '+baseUrl+'trips/share/'+tripId+'/'+shareKey;
          }
          FB.ui({
            method: 'feed',
            name: message,
            link: baseUrl+'trips/share/'+tripId+'/'+shareKey,
            picture: baseUrl+'images/sb_logo_75.jpg',
            caption: 'Shoutbound is bi-winning, duh.',
            description: 'David Xia is a god.',
            message: message
          },
          function(r) {
            if (r && r.post_id) {
              $('#div-to-popup').bPopup().close();
            }
          });
        }
      });    
    }
  });
  return false;
}


invite.tweet = function(shareRole) {
  var shareKey = invite.generateShareKey(shareRole, 2, 'tw');
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
}


invite.emailShare = function() {
  $('#share-methods').toggle();
  $('#email-input').toggle();
  $('#trip-share-toolbar').toggle();
}


invite.confirmShare = function(shareRole) {  
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
        invite.displaySuccessDialog(r);
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
        invite.displaySuccessDialog(r);
        invite.sendEmail(uids, shareRole);
      }
    });
  }
    
  $('#div-to-popup').bPopup().close();
  return false;
}


invite.displaySuccessDialog = function(r) {
  $('#div-to-popup').empty();
  $('#div-to-popup').append(r);
  $('#div-to-popup').bPopup();
  $('.success').click(function() {
    $('#div-to-popup').bPopup().close();
  });  
}


invite.sendEmail = function(uids, shareRole) {
  var postData = {
    uid: uid,
    tripId: tripId,
    uids: uids,
    shareRole: shareRole
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'trip_shares/send_email',
    data: postData,
  });
}


invite.generateShareKey = function(shareRole, shareMedium, targetId) {
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
  $('#invite-others-button').live('click', function() {
    invite.showShareDialog(2);
    return false;
  });
  $('#get-suggestions-button').live('click', function() {
    invite.showShareDialog(1);
    return false;
  });
});