$(function() {
  $('#trip-selection').multiselect();
});


$(function() {
  $('#post-item').click(function() {
    var text = getContentEditableText('item-input').trim();
    if (text.length > 0) {
      postItem(text);        
    }
    return false;
  });
});


$(function() {
  $('abbr.timeago').timeago();
});


$(function() {
  var delay;
  $('.tooltip').mouseover(function() {
    var img = $(this);
    
    delay = setTimeout(function() {
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
  }).mouseout(function() {
    $('.tooltip_container').remove();
    clearTimeout(delay);
  });
});


getContentEditableText = function(id) {
  var ce = $('<pre />').html($('#' + id).html());
  if ($.browser.webkit)
    ce.find('div').replaceWith(function() { return '\n' + this.innerHTML; });
  if ($.browser.msie)
    ce.find('p').replaceWith(function() { return this.innerHTML + '<br>'; });
  if ($.browser.mozilla || $.browser.opera || $.browser.msie)
    ce.find('br').replaceWith('\n');
  return ce.text();
}


postItem = function(text) {
  //console.log(text);
  var tripIds = $("select").multiselect("getChecked").map(function(){
     return this.value;
  }).get();
  console.log(tripIds);
  $.post(baseUrl+'home/ajax_post_item', {text:text, tripIds:tripIds},
    function (d) {
      console.log(d);
    });
}
