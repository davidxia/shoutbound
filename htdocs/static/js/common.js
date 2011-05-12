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
      var postId = $(this).parent().attr('id').match(/(\d+)$/)[1];
      $.post(baseUrl+'trips/ajax_delete_post', {postId:postId, tripId:tripId},
        function(d) {
          var r = $.parseJSON(d);
          if (r.success) {
            wall.removePost(r.id);
          }
        });
    }
  });
});