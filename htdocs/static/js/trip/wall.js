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
  $('.wallitem').live('mouseover mouseout', function(event) {
    if (event.type == 'mouseover') {
      $(this).children('.remove-wallitem').css('opacity', 1);
      $(this).siblings('.remove-wallitem').css('opacity', 0);
    } else {
      $(this).children('.remove-wallitem').css('opacity', 0);
      $(this).siblings('.remove-wallitem').css('opacity', 1);
    }
  });
};


wall.bindPostButton = function() {
  $('#wallitem-post-button').click(function() {
    if ($('#wallitem-input').val().length != 0) {
      var loggedin = loginSignup.getStatus();
      if (loggedin) {
        wall.postWallitem();
      } else {
        loginSignup.showDialog('wall post');
      }
    }
    return false;
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
    }
  });  
};


wall.displayWallitem = function(r) {
  var html = [];
  if (r.parentId) {
    html[0] = '<div class="wallitem reply" id="wallitem-'+r.id+'">';
    html[1] = '<a href="'+baseUrl+'profile/'+r.userId+'" class="author">'+r.userName+'</a>: ';
    html[2] = '<span class="content">'+r.content+'</span>';
    html[3] = '<div class="actionbar">';
    html[4] = '<a class="like-button" href="#">Like</a>';
    html[5] = '<span class="num-likes"></span>';
    html[6] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
    html[7] = '</div>';
    html[8] = '<div class="remove-wallitem"></div>';
    html[9] = '</div>';    
  } else {
    html[0] = '<div class="wallitem" id="wallitem-'+r.id+'">';
    html[1] = '<a href="'+baseUrl+'profile/'+r.userId+'">';
    html[2] = '<img src="'+staticSub+'profile_pics/'+r.userPic+'" height="30" width="30"/>';
    html[3] = '</a>';
    html[5] = '<a href="'+baseUrl+'profile/'+r.userId+'" class="author">'+r.userName+'</a>';
    html[7] = '<div class="content">'+r.content+'</div>';
    html[8] = '<div class="actionbar">';
    html[9] = '<a class="reply-button" href="#">Add comment</a>';
    html[10] = '<a class="like-button" href="#">Like</a>';
    html[11] = '<span class="num-likes"></span>';
    html[12] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
    html[13] = '</div>';
    html[14] = '<div class="remove-wallitem"></div>';
    html[15] = '</div>';
  }
  html = html.join('');
  
  if (r.parentId) {
    $('#wallitem-'+r.parentId).append(html);
  } else {
    $('#wall').append(html);  
    $('#wallitem-input').val('');
  }
  $('abbr.timeago').timeago();
  wall.bindLike();
};


wall.bindRemove = function() {
  $('.remove-wallitem').live('click', function() {
    // TODO: ask user to confirm removal
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec($(this).parent().attr('id'));
    
    var postData = {
      id: match[1]
    };
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'wallitems/ajax_remove',
      data: postData,
      success: function(r) {
        var r = $.parseJSON(r);
        wall.removeWallitem(r.id);
      }
    });
  });
};


wall.removeWallitem = function(id) {
  $('#wallitem-'+id).fadeOut(300, function() {
    $(this).remove();
  });
};


wall.bindReply = function() {
  $('.reply-button').click(function() {
    $(this).siblings('.reply-box').remove();
    var parentId = $(this).parent().parent().attr('id');
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec(parentId);
    parentId = match[1];

    var replyBox = $('<div class="reply-box" style="margin-left:24px;"><textarea style="height:14px; display:block; overflow:hidden; resize:none; line-height:13px; width:445px;"></textarea></div>');
    $(this).parent().append(replyBox);
    var replyInput = replyBox.children('textarea');
    replyInput.focus();
    wall.loadReplyEnter(replyInput);
    return false;
  });
};


// hitting enter posts the reply
wall.loadReplyEnter = function(replyInput) {
  replyInput.keydown(function(e) {
    var keyCode = e.keyCode || e.which,
        enter = 13;
    if (keyCode == enter) {
      e.preventDefault();
      var loggedin = loginSignup.getStatus();
      var regex = /^wallitem-(\d+)$/;
      var match = regex.exec(replyInput.parent().parent().parent().attr('id'));
      var parentId = match[1];
      if (loggedin) {
        wall.postReply(parentId);
      } else {
        loginSignup.showDialog('wall reply', parentId);
      }
    }
  });
};


wall.postReply = function(parentId) {  
  var postData = {
    tripId: tripId,
    parentId: parentId,
    content: $('#wallitem-'+parentId).find('textarea').val()
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'wallitems/ajax_save',
    data: postData,
    success: function(r) {
      var r = $.parseJSON(r);
      wall.displayWallitem(r);
      wall.removeReplyBox(parentId);
      wall.bindLike();
    }
  });  
};


wall.removeReplyBox = function(parentId) {
  $('#wallitem-'+parentId).find('.reply-box').remove();
};


wall.bindLike = function() {
  $('a.like-button, a.unlike-button').unbind();
  $('a.like-button').click(function() {
    var loggedin = loginSignup.getStatus();
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec($(this).parent().parent().attr('id'));
    var wallitemId = match[1];
    if (loggedin) {
      wall.saveLike(wallitemId, 1);
    } else {
      loginSignup.showDialog('wall like', wallitemId, 1);
    }
    return false;
  });

  $('a.unlike-button').click(function() {
    var loggedin = loginSignup.getStatus();
    if (loggedin) {
      var regex = /^wallitem-(\d+)$/;
      var match = regex.exec($(this).parent().parent().attr('id'));
      var wallitemId = match[1];
      wall.saveLike(wallitemId, 0);
    } else {
      loginSignup.showDialog('wall like', wallitemId, 0);
    }
    return false;
  });
};


wall.saveLike = function(wallitemId, isLike) {
  var postData = {
    wallitemId: wallitemId,
    isLike: isLike
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'wallitems/ajax_save_like',
    data: postData,
    success: function(r) {
      var r = $.parseJSON(r);
      if (r.success) {
        wall.displayLike(r.wallitemId, r.isLike);
      } else {
        alert('something broken. Tell David to fix it.');
      }
    }
  });
};


wall.displayLike = function(wallitemId, isLike) {
  var actionbar = $('#wallitem-'+wallitemId).children('div.actionbar');
  var numLikes = actionbar.children('span.num-likes');
  var regex = /^\d+/;
  console.log(numLikes);
  var match = regex.exec(numLikes.html());
  if (isLike == 1 && match == null) {
    actionbar.children('abbr.timeago').before('<span class="num-likes">1 person likes this</span>');
  } else if (isLike == 1) {
    var n = match[0];
    if (n == 1) {
      numLikes.html('2 people like this');
    } else {
      n++;
      numLikes.html(n+' people like this');
    }
  } else if (isLike == 0) {
    var n = match[0];
    if (n == 2) {
      numLikes.html('1 person likes this');
    } else {
      n--;
      numLikes.html(n+' people like this');
    }
  }
  wall.unbindLike(wallitemId, isLike);
};


wall.unbindLike = function(wallitemId, isLike) {
  var actionbar = $('#wallitem-'+wallitemId).children('div.actionbar');
  if (isLike == 1) {  
    var like = actionbar.children('a.like-button');
    like.removeClass('like-button').addClass('unlike-button').html('Unlike');
  } else {
    var unlike = actionbar.children('a.unlike-button');
    unlike.removeClass('unlike-button').addClass('like-button').html('Like');
  }
  wall.bindLike();
};


$(document).ready(function() {
  wall.showTimeago();
  wall.showRemove();
  $('#wallitem-input').labelFader();
  wall.bindPostButton();
  wall.bindRemove();
  wall.bindReply();
  wall.bindLike();
});