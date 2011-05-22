$(function() {
  $('#save-places-been').click(function() {
    //$('#places-been-form').submit();
    var placesDates = [];
    var n = $('.places_dates').length;
    for (var i=0; i<n; i++) {
      var placeId = $('#place_id'+i).val();
      var date = $('#date'+i).val();
      placesDates.push({placeId:placeId, date:date});
    }
    
    $.post(baseUrl+'profile/ajax_save_user_places', {placesDates:placesDates},
      function(d) {
        var r = $.parseJSON(d);
        if (r.success) {
          $('#save-response').empty().text(r.response).show().delay(10000).fadeOut(250);
        }
      });
    return false;
  });


  // only show month and year
  $('.date').live('focus', function() {
    $(this).datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
        maxDate: 0,
        onClose: function(dateText, inst) { 
            var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val();
            var year = $('#ui-datepicker-div .ui-datepicker-year :selected').val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
  });
  
  
  // dynamic form plugin for multiple destinations
  $('.places_dates').dynamicForm('#add-place', '#subtract-place', {limit: 10});


/*
  $.validator.addMethod(
      'monthYear',
      function(val, ele) {
          return val.match(/^((0[1-9])|(1[0-2]))\/(\d{4})$/);
      },
      'Please enter a date in the format mm/yyyy'
  );
  $('#places-been-form').validate({
    rules: {
      date: {
        monthDate: true
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo( element.siblings('.label-and-errors').children('.error-message') );
    }
  });
*/


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