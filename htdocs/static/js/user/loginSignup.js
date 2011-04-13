var loginSignup = {};

loginSignup.getStatus = function() {
  var loggedin;
  $.ajax({
    async: false,
    type: 'POST',
    url: baseUrl+'users/ajax_get_logged_in_status',
    success: function(r) {
      var r = $.parseJSON(r);
      loggedin = r.loggedin;
    }
  });
  return loggedin;
};


loginSignup.showDialog = function (callback, id, param) {
  var postData = {
    callback: callback,
    id: id,
    param: param
  };
  
  $.ajax({
    type: 'POST',
    data: postData,
    url: baseUrl+'users/login_signup',
    success: function(r) {
      var r = $.parseJSON(r);
      $('#div-to-popup').empty().append(r.data).bPopup({follow:false, opacity:0});
    }
  });
};


loginSignup.success = function(callback, id, param) {
  var id = id;
  switch (callback) {
    case 'create trip':
      $('#trip-creation-form').submit();
      break;
    case 'wall post':
      $('#div-to-popup').empty();
      wall.postWallitem();
      break;
    case 'wall reply':
      $('#div-to-popup').empty();
      wall.postReply(id);
      break;
    case 'wall like':
      $('#div-to-popup').empty();
      wall.saveLike(id, param);
      window.location.reload();
      break;
  }
};