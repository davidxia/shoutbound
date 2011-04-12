var wall = {};

$.fn.labelFader = function() {
  var f = function() {
    var $this = $(this);
    if ($this.val()) {
      $this.siblings('label').children('span').hide();
    } else {
      $this.siblings('label').children('span').fadeIn('fast');
    }
  };
  this.focus(f);
  this.blur(f);
  this.keyup(f);
  this.change(f);
  this.each(f);
  return this;
};


// convert unix timestamps to time ago
wall.showTimeago = function() {
  $('abbr.timeago').timeago();
};


wall.showRemove = function() {
  $('#wall').children('.wallitem').hover(
    function() {
      $(this).children('.remove-wallitem').css('opacity', 1);
    },
    function() {
      $(this).children('.remove-wallitem').css('opacity', 0);
    }
  );
};


wall.loadPostButton = function() {
  $('#wallitem-post-button').click(function() {
    if ($('#wallitem-input').val().length != 0) {
      $.ajax({
        type: 'POST',
        url: baseUrl+'users/ajax_get_logged_in_status',
        success: function(r) {
          var r = $.parseJSON(r);
          if (r.loggedin) {
            wall.postWallitem();
          } else {
            wall.showLoginSignupDialog();
          }
        }
      });
    }
    return false;
  });
};


wall.showLoginSignupDialog = function() {
  $.ajax({
    url: baseUrl+'users/login_signup',
    success: function(r) {
      var r = $.parseJSON(r);
      $('#div-to-popup').empty().append(r.data).bPopup({follow:false, opacity:0});
    }
  });
};


wall.postWallitem = function() {
  var postData = {
    tripId: tripId,
    content: $('#wallitem-input').val()
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'wallitems/ajax_save',
    data: postData,
    success: function(r) {
      var r = $.parseJSON(r);
      wall.displayWallitem(r);
      $('abbr.timeago').timeago();
      $('#wallitem-input').val('');
    }
  });  
};


wall.displayWallitem = function(r) {
  var html = [];
  html[0] = '<div class="wallitem" id="wallitem-'+r.id+'">';
  html[1] = '<div class="author">';
  html[2] = r.userName;
  html[3] = '</div>';
  html[4] = ' <div class="remove-wallitem"></div>';
  html[5] = '<div class="content">'+r.content+'</div>';
  html[6] = '<br/>';
  html[7] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
  html[8] = '</div>';
  html = html.join('');
  
  $('#wall').append(html);
};


wall.remove = function() {
  $('.remove-wallitem').click(function() {
    // TODO: ask user to confirm removal
    // remove wall item
  });
};



$(document).ready(function() {
  wall.showTimeago();
  wall.showRemove();
  $('#wallitem-input').labelFader();
  wall.loadPostButton();
  wall.remove();
});