var cache = {};

$(function() {
  $('abbr.timeago').timeago();

  $('#follow').live('click', function() {
    $.post(baseUrl+'places/ajax_edit_follow', {placeId:placeId, follow:1},
      function(d) {
        console.log(d);
      });
    return false;
  });

  $('#unfollow').live('click', function() {
    $.post(baseUrl+'places/ajax_edit_follow', {placeId:placeId, follow:0},
      function(d) {
        console.log(d);
      });
    return false;
  });

  var defaultTab = $('#main-tabs').find('a:first').attr('href').substring(1);
  loadTabs(defaultTab);
});


$(function() {
  var delay;
  $('.tooltip').live('mouseover mouseout', function(e) {
    if (e.type == 'mouseover') {
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
    } else {
      $('.tooltip_container').remove();
      clearTimeout(delay);
    }
  });


  var rightTabs = $('#right-tabs');
  rightTabs.children('li:first').addClass('active');
  rightTabs.children('li').click(function() {
    var tabName = $(this).children('a').attr('href');
    console.log(tabName);
    $(this).parent().children().removeClass('active');
    $(this).addClass('active');
    $('.right-tab-content').hide();
    $(tabName+'-tab').show().css('visibility', 'visible');
    return false;
  });
  
  dbpediaQuery($('#place-name').text(), $('#admin1').text());
});


loadTabs = function(defaultTab) {
  $(window).bind('hashchange', function(e) {
    var tabName = $.param.fragment();
    var path = window.location.pathname;
    var matches = path.match(/\d*$/);
    myUrl = baseUrl+'places';
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
      //map.clearMarkers();
      //map.showTabMarkers(defaultTab);
    } else if (cache[tabName]) {
      $('#'+tabName+'-tab').show();
      //map.clearMarkers();
      //map.showTabMarkers(tabName);
    } else {
      $('#main-tab-loading').show();
      $.get(myUrl, function(d) {
        $('#main-tab-loading').hide();
        $('#main-tab-container').append(d);
        $('abbr.timeago').timeago();
        cache[tabName] = $(d);
        //map.saveMarkers(tabName);
        //map.clearMarkers();
        //map.showTabMarkers(tabName);
      });
    }
  });
  $(window).trigger('hashchange');
};


function dbpediaQuery(placeName, admin1) {
  var query = placeName+' '+admin1;
  var altQuery = placeName;
  console.log(query);
  console.log(altQuery);
  $.post(baseUrl+'places/ajax_dbpedia_query', {query:query, altQuery:altQuery},
    function(d) {
      var r = $.parseJSON(d);
      //console.log(r);
      if (r) {
        $('#name').html(r.label.value);
        var abstract = r.abstract.value;
        // add ellipses if abstract doesn't end with period
        if ( ! abstract.match(/\.$/)) {
          abstract += '...';
        }
        $('#abstract').html(abstract);
        //textShorten($('#abstract'));
        $('#gallery-tab').append('<img src="'+r.thumbnail.value+'"/>');
      } else {
        $('#abstract').html('sorry, we couldn\'t find any info on that');
      }
    });
  return false;
}
