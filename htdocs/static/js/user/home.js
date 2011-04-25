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


postItem = function(content) {
  var tripIds = $('select').multiselect('getChecked').map(function(){
     return this.value;
  }).get();
  $.post(baseUrl+'home/ajax_post_item', {content:content, tripIds:tripIds},
    function (d) {
      var r = $.parseJSON(d);
      showPost(r);
    });
}


showPost = function(r) {
  $('#item-input').text('');
  $('#trip-selection').multiselect('uncheckAll');
  console.log(r);
}


$(function() {
  var cache = {};
  
  $(window).bind('hashchange', function(e) {
    var url = $.param.fragment();
    var path = window.location.pathname;
    var matches = path.match(/\d*$/);
    myUrl = baseUrl+'home';
    if (url) {
      myUrl += '/'+url;
    }
    if (matches[0]) {
      myUrl += '/'+matches[0];
    }
    $('li.active').removeClass('active');
    $('#main-tab-container').children(':visible').hide();

    if (url == '') {
      $('a[href="#feed"]').parent().addClass('active');
    } else {
      $('a[href="#'+url+'"]').parent().addClass('active');
    }
    
    if (url=='feed' || url=='') {
      $('#feed-tab').show();
    } else if (cache[url]) {
      $('#'+url+'-tab').show();
    } else {
      $('#main-tab-loading').show();
      $.get(myUrl, function(d) {
        $('#main-tab-loading').hide();
        $('#main-tab-container').append(d);
        $('abbr.timeago').timeago();
        cache[url] = $(d);
      });
    }
  });
  
  $(window).trigger('hashchange');
});