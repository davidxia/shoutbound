var cache = {};


$(function() {
  if ($('#main-tabs').length > 0) {
    var defaultTab = $('#main-tabs').find('a:first').attr('href').substring(1);
    $(window).bind('hashchange', function(e) {
      var tabName = $.param.fragment();
      var path = window.location.pathname;
      var matches = path.match(/\d*$/);
      var m = path.match(/^\/\w+\/(\w+)/);
      myUrl = baseUrl+m[1];
      if (tabName) {
        myUrl += '/'+tabName;
      }
      if (matches[0]) {
        myUrl += '/'+matches[0];
      }
      $('li.active').removeClass('active');
      $('#main-tab-container').children(':visible').hide();
      
      if (tabName == '') {
        $('a[href="#'+defaultTab+'"]').parent().addClass('active');
      } else {
        $('a[href="#'+tabName+'"]').parent().addClass('active');
      }
      
      if (tabName==defaultTab || tabName=='') {
        $('#'+defaultTab+'-tab').show();
      } else if (cache[tabName]) {
        $('#'+tabName+'-tab').show();
      } else {
        $('#main-tab-loading').show();
        $.get(myUrl, function(d) {
          $('#main-tab-loading').hide();
          $('#main-tab-container').append(d);
          if ($('abbr.timeago').length > 0) {
            $('abbr.timeago').timeago();
          }
          cache[tabName] = $(d);
        });
      }
    });
    $(window).trigger('hashchange');
  }


  $.getScript(baseUrl+'static/js/jquery/timeago.js', function() {
    $('abbr.timeago').timeago();
  });


  var ttDelay;
  $('.tooltip').live('mouseover mouseout', function(e) {
    if (e.type == 'mouseover') {
      var img = $(this);
      ttDelay = setTimeout(function() {
        var title = img.attr('alt');
        var element_offset = img.offset(),
            element_top = element_offset.top,
            element_left = element_offset.left,
            element_height = img.height(),
            element_width = img.width();
        var tooltip = $('<div class="tooltip_container"><div class="tooltip_interior">'+title+'</div></div>');
        $('body').append(tooltip);
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

  if ($('#right-content-container').length > 0) {
    var top = $('#right-content-container').offset().top - parseFloat($('#right-content-container').css('marginTop').replace(/auto/, 0));
  }
  var didScroll = false;
  $(window).scroll(function () {
    didScroll = true;
  });
  setInterval(function() {
    if (didScroll) {
      didScroll = false;
      var y = $(window).scrollTop();    
      if (y >= top) {
        $('#right-content-container').addClass('map-fixed');
      } else {
        $('#right-content-container').removeClass('map-fixed');
      }
    }
  }, 100);
  
  
  jqMultiselect();
  loadPolymap();
});


jqMultiselect = function() {  
  if ($('select').length > 0) {
    $(document.createElement('link')).attr({
        href: baseUrl+'static/css/excite-bike/jquery-ui-1.8.11.custom.css',
        media: 'screen',
        type: 'text/css',
        rel: 'stylesheet'
    }).appendTo('head');
    $.getScript(baseUrl+'static/js/jquery/jquery-ui-1.8.11.custom.min.js', function() {
      $.getScript(baseUrl+'static/js/jquery/multiselect.min.js', function() {
        $('select').multiselect();
      });
    });
  }
}


loadPolymap = function() {  
  if ($('#map-canvas').length > 0) {
    $.getScript(baseUrl+'static/js/polymaps.min.js?2.5.0', function() {
      po = org.polymaps;
      
      map = po.map()
          .container(document.getElementById('map-canvas').appendChild(po.svg('svg')))
          .add(po.drag())
          .add(po.wheel())
          .add(po.dblclick());
      
      map.add(po.image()
          .url(po.url('http://{S}tile.cloudmade.com'
          + '/baa414b63d004f45863be327e9145ec4'
          + '/998/256/{Z}/{X}/{Y}.png')
          .hosts(['a.', 'b.', 'c.', ''])));
      
      map.extent([{lon:swLng, lat:swLat}, {lon:neLng, lat:neLat}]);
      
      map.add(po.compass()
          .pan('none'));
          
      addMarkers();
    });
  }
}

function addMarkers() {
  $("[class='place']").each(function(i,ele) {
    var marker = po.geoJson()
        .features([
            {geometry: {type:'Point', coordinates:[parseInt(ele.getAttribute('lng')), parseInt(ele.getAttribute('lat'))]}}
        ])
        .on('load', po.stylist().attr('fill', 'red')
        .title(ele.getAttribute('title')));
    map.add(marker);
  });
}