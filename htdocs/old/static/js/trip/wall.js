var wall = {};
var cache = {};
wall.scrollElem;


wall.bindLike = function() {
  $('a.like-button, a.unlike-button').unbind();
  $('a.like-button').click(function() {
    var loggedin = loginSignup.getStatus();
    var postId = $(this).parent().parent().attr('id').match(/^post-(\d+)$/)[1];
    if (loggedin) {
      wall.saveLike(postId, 1);
    } else {
      loginSignup.showDialog('wall like', postId, 1);
    }
    return false;
  });

  $('a.unlike-button').click(function() {
    var loggedin = loginSignup.getStatus();
    if (loggedin) {
      var postId = $(this).parent().parent().attr('id').match(/^post-(\d+)$/)[1];
      wall.saveLike(postId, 0);
    } else {
      loginSignup.showDialog('wall like', postId, 0);
    }
    return false;
  });
};


wall.saveLike = function(postId, isLike) {  
  $.post(baseUrl+'posts/ajax_set_like', {postId:postId, isLike:isLike},
    function(d) {
      var r = $.parseJSON(d);
      if (r.success) {
        wall.displayLike(r.postId, r.isLike);
      } else {
        alert('something broken. Tell David to fix it.');
      }
    });
};


wall.displayLike = function(postId, isLike) {
  var actionbar = $('#post-'+postId).children('div.actionbar');
  var numLikes = actionbar.children('span.num-likes');
  var regex = /^\d+/;
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
  wall.unbindLike(postId, isLike);
};


wall.unbindLike = function(postId, isLike) {
  var actionbar = $('#post-'+postId).children('div.actionbar');
  if (isLike == 1) {  
    var like = actionbar.children('a.like-button');
    like.removeClass('like-button').addClass('unlike-button').html('Unlike');
  } else {
    var unlike = actionbar.children('a.unlike-button');
    unlike.removeClass('unlike-button').addClass('like-button').html('Like');
  }
  wall.bindLike();
};


wall.bindPlaces = function(marker, i) {
  $('a.place:eq('+i+')').click(function() {
    $(document).trigger('click');
    map.googleMap.panTo(marker.getPosition());
    var image = new google.maps.MarkerImage(baseUrl+'static/images/marker_sprite.png',
      new google.maps.Size(20, 34),
      new google.maps.Point(20, 0),
      new google.maps.Point(10, 34));
    marker.setOptions({
      icon: image
    });

    // highlight corresponding post text
    var placeText = $(this);
    placeText.animate({
      backgroundColor: '#fffb2c',
    }, 250, function() {
      $(document).one('click', function() {
        // reset text and marker icon when user clicks elsewhere
        placeText.css({'background-color': '#ffffff'});
        
        image = new google.maps.MarkerImage(baseUrl+'static/images/marker_sprite.png',
          new google.maps.Size(20, 34),
          new google.maps.Point(0, 0),
          new google.maps.Point(10, 34));
        marker.setOptions({
          icon: image
        });
      });
    });
    
    return false;
  });
};


// use the first element that is scrollable
wall.scrollableElement = function(els) {
  for (var i = 0, argLength = arguments.length; i <argLength; i++) {
    var el = arguments[i],
        $scrollElement = $(el);
    if ($scrollElement.scrollTop()> 0) {
      return el;
    } else {
      $scrollElement.scrollTop(1);
      var isScrollable = $scrollElement.scrollTop()> 0;
      $scrollElement.scrollTop(0);
      if (isScrollable) {
        return el;
      }
    }
  }
  return [];
}


$(function() {
  wall.bindLike();

  $('ul#right-tabs').children().click(function() {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $('#'+$(this).attr('tab')+'-tab').siblings().hide();
    $('#'+$(this).attr('tab')+'-tab').show();
    return false;
  });
});