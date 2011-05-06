$(function () {
  $('.follow').live('click', function() {
    var id = $(this).attr('id').match(/^(\w+)-(\d+)$/);
    var type = id[1];
    id = id[2];
    if (loginSignup.getStatus()) {
      editFollowing(type, id, 1);
      console.log(loginSignup.getStatus());
    } else {
      loginSignup.showDialog('follow '+type, id, 1);
    }
    return false;
  });
  
  $('.unfollow').live('click', function() {
    var id = $(this).attr('id').match(/^(\w+)-(\d+)$/);
    var type = id[1];
    id = id[2];
    editFollowing(type, id, 0);
    return false;
  });
});


editFollowing = function(type, id, follow) {
  switch(type) {
    case 'user':
      var url = 'profile/ajax_edit_following',
          postData = {profileId:id, follow:follow};
      break;
    case 'trip':
      var url = 'trips/ajax_save_rsvp',
          rsvp = (follow == 1) ? 3 : 0,
          postData = {tripId:id, rsvp:rsvp};
      break;
    case 'place':
      var url = 'places/ajax_edit_follow',
          postData = {placeId:id, follow:follow};
      break;
  }
  $.post(baseUrl+url, postData,
    function(d) {
      changeFollowButton(d);
    });
};


changeFollowButton = function(d) {
  var r = $.parseJSON(d);
  if (r.success) {
    if (r.follow == 0 || r.rsvp == 0) {
      $('#'+r.type+'-'+r.id).removeClass('unfollow').addClass('follow').text('Follow');
    } else {
      $('#'+r.type+'-'+r.id).removeClass('follow').addClass('unfollow').text('Unfollow');
    }
  } else {
    alert('something broke. please try again');
  }
};
