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