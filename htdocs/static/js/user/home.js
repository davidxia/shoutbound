var cache = {};
var map = {};


$(function() {
  $('#post-input').focus(function() {
    $(this).next().show();
  });
});


$(function() {
  var po = org.polymaps;
  
  var polymap = po.map()
      .container(document.getElementById('map-canvas').appendChild(po.svg('svg')))
      .add(po.drag())
      .add(po.wheel())
      .add(po.dblclick());
  
  polymap.add(po.image()
      .url(po.url('http://{S}tile.cloudmade.com'
      + '/baa414b63d004f45863be327e9145ec4'
      + '/998/256/{Z}/{X}/{Y}.png')
      .hosts(['a.', 'b.', 'c.', ''])));
  
  polymap.extent([{lon:-180, lat:-50}, {lon:180, lat:50}]);
    
  polymap.add(po.compass()
      .pan('none'));
});


loadTabs = function(defaultTab) {
  $(window).bind('hashchange', function(e) {
    var tabName = $.param.fragment();
    var path = window.location.pathname;
    var matches = path.match(/\d*$/);
    myUrl = baseUrl+'home';
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
        $('abbr.timeago').timeago();
        cache[tabName] = $(d);
      });
    }
  });
  
  $(window).trigger('hashchange');
};