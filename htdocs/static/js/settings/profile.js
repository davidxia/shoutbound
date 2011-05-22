$(function() {
  // flash/js plugin for uploading profile pic
  $('#file_upload').uploadify({
    'uploader'       : baseUrl+'static/js/uploadify/uploadify.swf',
    'script'         : baseUrl+'profile/profile_pic_uploadify',
    'scriptData'     : {'uid':uid},
    'cancelImg'      : baseUrl+'static/images/cancel.png',
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'auto'           : true,
    'sizeLimit'      : 102400,
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
        bio.val(r.bio);
        $('#save-response').empty().text(r.response).show().delay(10000).fadeOut(250);
      });
    return false;
  });
  

  $('.place-input').live('keyup', function(e) {
    var keyCode = e.keyCode || e.which;
    // ignore non-char keys
    var nonChars = [9,13,16,17,18,20,27,33,34,35, 36,37,38,39,40,45,91,93,112,113,114,115,116,117,118,119,120,121,122,123,144];
    var query = $.trim($(this).val());
    if ($.inArray(keyCode, nonChars)==-1 && query.length>2) {
      var input = $(this);
      var f = function () {placeAutocomplete(query, input);};
      delay(f, 200);
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
  spinner.show();
  $.post(baseUrl+'places/ajax_autocomplete', {query:query, isSettings:true},
    function(d) {
      $('#autocomplete-results').remove();
      spinner.hide();
      input.after(d);
      $('#autocomplete-results').children().click(function() {
        var a = $(this).children('a'),
            id = a.attr('id').match(/^place-(\d+)$/)[1],
            name = a.text();
        autocompleteClick(id, name, input);
        return false;
      });
    });
};


autocompleteClick = function(id, name, input) {
  input.val(name);
  input.siblings('.place_id').val(id);
  var e = $.Event('keydown');
  e.keyCode = 27;
  input.trigger(e);
  return false;
};
