$(function() {
  // flash/js plugin for uploading profile pic
  $('#file_upload').uploadify({
    'uploader'       : baseUrl+'static/js/uploadify/uploadify.swf',
    'script'         : baseUrl+'profile/profile_pic_uploadify',
    'scriptData'     : {'uid':uid},
    'cancelImg'      : baseUrl+'images/cancel.png',
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'auto'           : true,
    'sizeLimit'      : 10240,
    'fileExt'        : '*.jpg;*.gif;*.png',
    'fileDesc'       : 'Image Files',
    'buttonText'     : 'Change picture',
  });


  $('#save-profile').click(function() {
    var bio = $('#bio'),
        url = $('#url'),
        currPlaceId = $('#current-place-id').val();
    
    var urlVal = url.val();
    if (url.val() && !urlVal.match(/^[a-zA-Z]+:\/\//)) {
      urlVal = 'http://' + urlVal;
    }

    $.post(baseUrl+'profile/ajax_save_profile', {bio:bio.val(), url:urlVal, currPlaceId:currPlaceId},
      function(d) {
        var r = $.parseJSON(d);
        url.val(r.url);
        $('#current-place').val(r.currPlace);
        $('#save-response').empty().text(r.response).show().delay(10000).fadeOut(250);
      });
    return false;
  });
  

  $('#save-been-to').click(function() {
    //$('#been-to-form').submit();
    var places = [];
    var n = $('.places_dates').length;
    for (var i=0; i<n; i++) {
      var placeId = $('#place_id'+i).val();
      var date = $('#date'+i).val();
      places.push({placeId:placeId, date:date});
    }
    //console.log(places);
    $.post(baseUrl+'profile/ajax_save_user_places', {places:places},
      function(d) {
        var d = $.parseJSON(d);
        //console.log(d);
        if (d.success) {
          alert('saved, refresh the page');
        }
      });
    return false;
  });


  // datepicker jquery plugin
  $('.date').live('focus', function() {
    $(this).datepicker();
  });
  
  
  // dynamic form plugin for multiple destinations
  $('.places_dates').dynamicForm('#add-place', '#subtract-place', {limit: 10});


  $('#been-to-form').validate({
    rules: {
      startdate: {
        date: true
      },
      enddate: {
        date: true
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
    }
  });


  $('.place-input').live('keyup', function(e) {
    var keyCode = e.keyCode || e.which;
    // ignore non-char keys
    var nonChars = [9, 13, 16, 17, 18, 20, 33, 34, 35, 36, 37, 38, 39, 40, 45, 91, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 144];
    var query = $.trim($(this).val());
    if ($.inArray(keyCode, nonChars)==-1 && query.length>2) {
      var input = $(this);
      var f = function () {placeAutocomplete(query, input);};
      delay(f, 250);
    }
  });
  
  // escape key clears the input
  $('.place-input').live('keydown', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 27) {
      $('#autocomplete-results').remove();
    }
  });


  $('#bio').keyup(function() {
    var charsLeft = 250-$(this).val().length;
    $('#chars-remaining').text(charsLeft);
    if (charsLeft < 0) {
      $(this).val($(this).val().substring(0, 250));
    }
  });  
  $('#bio').trigger('keyup');
});


delay = (function() {
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


placeAutocomplete = function(query, input) {
  var spinner = input.siblings('.loading-places');
  console.log(input);
  console.log(spinner);
  spinner.show();
  $.post(baseUrl+'places/ajax_autocomplete', {query:query},
    function(r) {
      spinner.hide();
      var r = $.parseJSON(r);
      listPlaces(r.places, input);
    });
};


listPlaces = function(places, input) {
  $('#autocomplete-results').remove();
  var parent = $('<div id="autocomplete-results" style="display:none; position:absolute; width:310px; border:1px solid #DDD; cursor:pointer; padding:2px; z-index:100; background:white; font-size:13px;"></div>');
  input.after(parent);
  for (var id in places) {
    var div = $('<div></div>');
    div.html('<a href="#" place_id="'+id+'">'+places[id]+'</a>');
    div.click(function() {
      var a = $(this).children('a');
      autocompleteClick(a.attr('place_id'), a.text(), input);
      return false;
    });
    parent.append(div);
  }
  parent.show();
};


autocompleteClick = function(id, name, input) {
  input.val(name);
  input.siblings('.place_id').val(id);
  var e = $.Event('keydown');
  e.keyCode = 27;
  input.trigger(e);
  return false;
};
