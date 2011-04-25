var map = {};

map.googleMap;

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

  if ($('.destination').length > 0) {  
    google.maps.event.addListenerOnce(map.googleMap, 'bounds_changed', function() {
      $('.destination').each(function() {
        map.showDestMarkers($(this).attr('lat'), $(this).attr('lng'));
      });
    });
  }
};


map.showDestMarkers = function(lat, lng) {
  var markerLatLng = new google.maps.LatLng(lat, lng);
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
  
  var bounds = map.googleMap.getBounds();
  if (!bounds.contains(markerLatLng)) {
    bounds.extend(markerLatLng);
    map.googleMap.fitBounds(bounds);
  }
};


$(function() {
  $('abbr.timeago').timeago();
});


$(function() {
  if (isSelf) {
    $('#profile-pic-container').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
    $('#edit-profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
  }
});


$('#follow').click(function() {
  $.post(baseUrl+'friends/ajax_add_following', {profileId:profileId},
    function(data) {
      if (data == 1) {
        $('#follow').remove();
        $('#profile-col-right').prepend('Following');
      } else {
        alert('something broken, tell David');
      }
    });
  return false;
});


$(function() {
	$('.main-tab-content').hide();
	// show tab specified in url, default to activity
  var tab = window.location.hash;
  var isTab = ($.inArray(tab, ['#activity', '#trail', '#posts', '#following', '#followers']) == -1) ? false : true;
  if (!isTab) {
    tab = '#activity';
  }
  $(tab+'-tab').show();
  $('.main-tabs').find('a[href='+tab+']').parent().addClass('active');

  // bind click event to tabs
	$('ul.main-tabs li').click(function() {
		$('ul.main-tabs li').removeClass('active'); //Remove any "active" class
		$(this).addClass('active'); //Add "active" class to selected tab
		$('.main-tab-content').hide(); //Hide all tab content
		var activeTab = $(this).find('a').attr('href'); //Find the href attribute value to identify the active tab + content
		$(activeTab+'-tab').show();
	});

  // bind click event to stats list
	$('ul.stats-list li a').click(function() {
    $('ul.main-tabs li').removeClass('active');
		var activeTab = $(this).attr('href');
		$('.main-tab-content').hide();
		var activeTab = $(this).attr('href');
    $('.main-tabs').find('a[href='+activeTab+']').parent().addClass('active');
		$(activeTab+'-tab').show();
		return false;
	});
});



$(function() {
  // Keep a mapping of url-to-container for caching purposes.
  var cache = {
    // If url is '' (no fragment), display this div's content.
    '': $('.main-tab-default')
  };
  
  // Bind an event to window.onhashchange that, when the history state changes,
  // gets the url from the hash and displays either our cached content or fetches
  // new content to be displayed.
  $(window).bind('hashchange', function(e) {
    
    // Get the hash (fragment) as a string, with any leading # removed. Note that
    // in jQuery 1.4, you should use e.fragment instead of $.param.fragment().
    var url = $.param.fragment();
    var path = window.location.pathname;
    var matches = path.match(/\d*$/);
    myUrl = baseUrl+'profile';
    if (url) {
      myUrl += '/'+url;
    }
    if (matches[0]) {
      myUrl += '/'+matches[0];
    }
    console.log(myUrl);
    
    // Remove .bbq-current class from any previously "current" link(s).
    $('li.active').removeClass('active');
    
    // Hide any visible ajax content.
    $('.tab-container').children(':visible').hide();
    
    // Add .bbq-current class to "current" nav link(s), only if url isn't empty.
    url && $('a[href="#'+url+'"]').addClass('active');
    
    if (cache[url]) {
      // Since the element is already in the cache, it doesn't need to be
      // created, so instead of creating it again, let's just show it!
      cache[url].show();
    } else {
      // Show "loading" content while AJAX content loads.
      $('.main-tab-loading').show();
      
      // Create container for this url's content and store a reference to it in
      // the cache.
      cache[url] = $('<div class="main-tab-content"/>')
        
        // Append the content container to the parent container.
        .appendTo('.tab-container')
        
        // Load external content via AJAX. Note that in order to keep this
        // example streamlined, only the content in .infobox is shown. You'll
        // want to change this based on your needs.
        .load(myUrl, function() {
          // Content loaded, hide "loading" content.
          $('.main-tab-loading').hide();
        });
    }
  })
  
  // Since the event is only triggered when the hash changes, we need to trigger
  // the event now, to handle the hash the page may have loaded with.
  $(window).trigger('hashchange');
});