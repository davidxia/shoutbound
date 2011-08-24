$('.show-comments').live('click', function() {
  $(this).removeClass('show-comments').addClass('hide-comments');
  $(this).parent().siblings('.comments-container').show();
  $(this).parent().siblings('.comments-container').find('textarea').focus();
  return false;
});
$('.hide-comments').live('click', function() {
  $(this).removeClass('hide-comments').addClass('show-comments');
  $(this).parent().siblings('.comments-container').hide();
  return false;
});

$('.add-comment-button').live('click', function() {
  var content = $.trim($(this).siblings('textarea').val());
  if (content != '') {
    var parentId = $(this).parent().parent().parent().attr('id').match(/(\d+)$/)[1];
    $.post(baseUrl+'posts/ajax_save', {content:content, parentId:parentId},
      function (d) {
        var ele = $('#post-'+parentId).find('.comment-input-container');
        ele.children('textarea').val('');
        ele.before(d);
        $('abbr.timeago').timeago();
      });
  }
  return false;
});

$('.show-trips').live('click', function() {
  $(this).removeClass('show-trips').addClass('hide-trips');
  $(this).parent().prev().prev().children('a').removeClass('hide-comments').addClass('show-comments');
  $(this).parent().parent().siblings('.comments-container').hide();
  return false;
});
$('.hide-trips').live('click', function() {
  $(this).removeClass('hide-trips').addClass('show-trips');
  return false;
});

$('.add-to-trip').live('click', function() {
  $(this).parent().parent().siblings('.add-to-trip-cont').show();
  return false;
});

$('.post-to-trip').live('click', function () {
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