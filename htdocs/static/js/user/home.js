var map = {};

map.googleMap;
map.markers = {};

$(function() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'http://maps.google.com/maps/api/js?sensor=false&callback=map.loadGoogleMap';
  document.body.appendChild(script);
});


map.loadGoogleMap = function() {
  var mapOptions = {
  	disableDefaultUI: true,
  	mapTypeControl: true,
  	mapTypeControlOptions: {
  	  mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE]
    },
  	zoomControl: true,
  	zoomControlOptions: {
      style: google.maps.ZoomControlStyle.LARGE,
    },
  	zoom: 0,
  	center: new google.maps.LatLng(0,0),
  	mapTypeId: google.maps.MapTypeId.ROADMAP,    
    scrollwheel: false
  };
  
  map.googleMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
};


map.showDestMarkers = function(tab) {
  $.each(map.markers[tab], function() {
    var markerLatLng = new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng'));
    var image = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
        new google.maps.Size(20, 34),
        new google.maps.Point(0, 0),
        new google.maps.Point(10, 34));
    var shadow = new google.maps.MarkerImage(baseUrl+'images/marker_sprite.png',
        new google.maps.Size(25, 20),
        new google.maps.Point(40, 14),
        new google.maps.Point(0, 20));
    var marker = new google.maps.Marker({
      map: map.googleMap,
      position: markerLatLng,
      icon: image,
      shadow: shadow
    });
    
    /*var bounds = map.googleMap.getBounds();
    if (!bounds.contains(markerLatLng)) {
      bounds.extend(markerLatLng);
      map.googleMap.fitBounds(bounds);
    }*/
  });

};


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
  //console.log(r);
}


$(function() {
  var cache = {};
  
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
    //console.log(tabName);
    $('li.active').removeClass('active');
    $('#main-tab-container').children(':visible').hide();

    if (tabName == '') {
      $('a[href="#feed"]').parent().addClass('active');
    } else {
      $('a[href="#'+tabName+'"]').parent().addClass('active');
    }
    
    if (tabName=='feed' || tabName=='') {
      $('#feed-tab').show();
    } else if (cache[tabName]) {
      $('#'+tabName+'-tab').show();
    } else {
      $('#main-tab-loading').show();
      $.get(myUrl, function(d) {
        $('#main-tab-loading').hide();
        $('#main-tab-container').append(d);
        $('abbr.timeago').timeago();
        cache[tabName] = $(d);
        map.markers[tabName] = [];
        cache[tabName].find('a.destination').each(function() {
          map.markers[tabName].push({lat: $(this).attr('lat'), lng:$(this).attr('lng')});
        });
                        
        console.log(map.markers);
        map.showDestMarkers(tabName);
      });
    }
    
    
  });
  
  $(window).trigger('hashchange');
});