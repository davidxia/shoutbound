var loginSignup = {};

loginSignup.getStatus = function() {
  var loggedin;
  $.ajax({
    async: false,
    type: 'POST',
    url: baseUrl+'users/ajax_get_logged_in_status',
    success: function(d) {
      var r = $.parseJSON(d);
      loggedin = r.loggedin;
    }
  });
  return loggedin;
};


loginSignup.showDialog = function(callback, id, param) {  
  $.getScript(baseUrl+'static/js/jquery/popup.js', function() {
    $.post(baseUrl+'users/login_signup', {callback:callback, id:id, param:param},
      function(d) {
        var r = $.parseJSON(d);
        var popup = $('<div id="login-signup-popup" style="display:none;"/>');
        $('body').append(popup);
        popup.append(r.data).bPopup({follow:false, opacity:0});
      });
  });
};


loginSignup.success = function(callback, id, param) {
  var id = id;
  switch (callback) {
    case 'create trip':
      $('#trip-creation-form').submit();
      break;
    case 'wall post':
      wall.savePost();
      window.location.reload();
      break;
    case 'wall reply':
      wall.postReply(id);
      window.location.reload();
      break;
    case 'wall like':
      wall.saveLike(id, param);
      break;
    case 'follow user':
      editFollowing('user', id, param);
      break;
    case 'follow trip':
      editFollowing('trip', id, param);
      break;
    case 'follow place':
      editFollowing('place', id, param);
      break;
  }
  $('#login-signup-popup').remove();
  $('.header').load(baseUrl+'login/ajax_change_header');
};