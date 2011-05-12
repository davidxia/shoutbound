$(function() {
  $.getScript(baseUrl+'static/js/jquery/timeago.js', function() {
    $('abbr.timeago').timeago();
  });


  var ttDelay;
  $('.tooltip').live('mouseover mouseout', function(e) {
    if (e.type == 'mouseover') {
      var img = $(this);
      ttDelay = setTimeout(function() {
        var title = img.attr('alt');
        // element location and dimensions
        var element_offset = img.offset(),
            element_top = element_offset.top,
            element_left = element_offset.left,
            element_height = img.height(),
            element_width = img.width();
        var tooltip = $('<div class="tooltip_container"><div class="tooltip_interior">'+title+'</div></div>');
        $('body').append(tooltip);
        // tooltip dimensions
        var tooltip_height  = tooltip.height();
        var tooltip_width = tooltip.width();
        tooltip.css({ top: (element_top + element_height + 3) + 'px' });
        tooltip.css({ left: (element_left - (tooltip_width / 2) + (element_width / 2)) + 'px' });
      }, 200);
    } else {
      $('.tooltip_container').remove();
      clearTimeout(ttDelay);
    }
  });


  $('.deleteable').live('mouseover mouseout', function(event) {
    if (event.type == 'mouseover') {
      $(this).children('.delete').css('opacity', 1);
      $(this).siblings('.delete').css('opacity', 0);
    } else {
      $(this).children('.delete').css('opacity', 0);
      $(this).siblings('.delete').css('opacity', 1);
    }
  });


  $('.delete').live('click', function() {
    if (window.confirm('are you sure you want to delete this post?')) {
      var m = $(this).parent().attr('id').match(/^(\w+)-(\d+)$/);
      var type = m[1];
      var id = m[2];
      console.log(type);
      console.log(id);
      if (type == 'activity') {
        $.post(baseUrl+'home/ajax_delete_activity', {activityId:id},
          function(d) {
            var r = $.parseJSON(d);
            if (r.success) {
              $('#activity-'+id).fadeOut(300, function() {
                $(this).remove();
              });
            }
          });
      } else if (type == 'post') {
        $.post(baseUrl+'trips/ajax_delete_post', {postId:id, tripId:tripId},
          function(d) {
            var r = $.parseJSON(d);
            if (r.success) {
              $('#post-'+id).fadeOut(300, function() {
                $(this).remove();
              });
            }
          });
      }
    }
  });
});