$('.show-comments').live('click', function() {
  $(this).removeClass('show-comments').addClass('hide-comments');
  $(this).parent().next().next().children('a').removeClass('hide-trips').addClass('show-trips');
  $(this).parent().parent().siblings('.trip-listing-container').hide();
  $(this).parent().parent().siblings('.comments-container').show();
  return false;
});
$('.hide-comments').live('click', function() {
  $(this).removeClass('hide-comments').addClass('show-comments');
  $(this).parent().parent().siblings('.comments-container').hide();
  return false;
});

$('.add-comment-button').live('click', function() {
  var content = $.trim($(this).siblings('textarea').val());
  if (content != '') {
    var parentId = $(this).parent().parent().parent().parent().attr('id').match(/(\d+)$/)[1];
    $.post(baseUrl+'posts/ajax_save', {content:content, parentId:parentId},
      function (d) {
        var r = $.parseJSON(d);
        var ele = $('#post-'+parentId).find('.comment-input-container');
        ele.children('textarea').val('');
        ele.before('<div class="comment"><div class="post-avatar-container"><a href="'+baseUrl+'profile/'+r.userId+'"><img src="'+staticUrl+'profile_pics/'+r.userPic+'" width="32" height="32"></a></div><div class="comment-content-container"><div class="comment-author-name"><a href="'+baseUrl+'profile/'+r.userId+'">'+r.userName+'</a></div><div class="comment-content">'+r.content+'</div><div class="comment-timestamp"><abbr class="timeago subtext" title="'+r.created+'">'+r.created+'</abbr></div></div></div>');
        $('abbr.timeago').timeago();
      });
  }
  return false;
});

$('.show-trips').live('click', function() {
  $(this).removeClass('show-trips').addClass('hide-trips');
  $(this).parent().prev().prev().children('a').removeClass('hide-comments').addClass('show-comments');
  $(this).parent().parent().siblings('.comments-container').hide();
  $(this).parent().parent().siblings('.trip-listing-container').show();
  return false;
});
$('.hide-trips').live('click', function() {
  $(this).removeClass('hide-trips').addClass('show-trips');
  $(this).parent().parent().siblings('.trip-listing-container').hide();
  return false;
});

$('.add-to-trip').live('click', function() {
  $(this).parent().parent().siblings('.add-to-trip-cont').show();
  return false;
});

$('.post-to-trip').live('click', function () {
  console.log('hi');
  var tripIds = $(this).siblings('select').multiselect('getChecked').map(function(){
    return this.value;
  }).get();
  var postId = $(this).parent().parent().parent().attr('id').match(/(\d+)$/)[1];
  $.post(baseUrl+'posts/ajax_save', {postId:postId, tripIds:tripIds},
    function (d) {
      var r = $.parseJSON(d);
      showPost(r);
    });
  return false;
});