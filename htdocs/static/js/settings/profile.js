$(function() {
  $('#username').keyup(function(e) {
    var keyCode = e.keyCode || e.which;
    var nonChars = [9,13,16,17,18,20,27,33,34,35, 36,37,38,39,40,45,91,93,112,113,114,115,116,117,118,119,120,121,122,123,144];
    var username = $.trim($(this).val());
    if (!username.match(/^[a-zA-Z0-9_]+$/)) {
      $('#username-help').empty().css('color', 'red').text('Only use letters, numbers, and \'_\'');
    } else if ($.inArray(keyCode, nonChars)==-1 && username.length>0) {
      $(this).siblings('span.subtext').text(baseUrl+username.toLowerCase());
      var f = function() {checkNameAvail(username);};
      delay(f, 300);
    }
  });

  // flash/js plugin for uploading profile pic
  if ($('#file_upload').length > 0) {
    $('#file_upload').uploadify({
      'uploader'       : baseUrl+'static/js/uploadify/uploadify.swf',
      'script'         : baseUrl+'profile/profile_pic_uploadify',
      'scriptData'     : {'uid':uid},
      'cancelImg'      : baseUrl+'static/images/cancel.png',
      'queueID'        : 'custom-queue',
      'removeCompleted': false,
      'auto'           : true,
      'sizeLimit'      : 102400,
      'fileExt'        : '*.jpg;*.jpeg;*.gif;*.png',
      'fileDesc'       : 'Image Files',
      'buttonText'     : 'Change picture',
      'onComplete'     : function(event, ID, fileObj, response, data) {
                           $('#profile-pic').attr('src', staticUrl+'profile_pics/'+uid+'_'+fileObj.name);
                         }
    });
  } 


  $('#save-profile').click(function() {
    var username = $('#username'),
        bio = $('#bio'),
        website = $('#website'),
        currPlaceId = $('#current-place-id').val();
    
    var websiteVal = website.val();
    if (website.val() && !websiteVal.match(/^[a-zA-Z]+:\/\//)) {
      websiteVal = 'http://' + websiteVal;
    }

    $.post(baseUrl+'users/ajax_save_profile', {username:username.val(), bio:bio.val(), website:websiteVal, currPlaceId:currPlaceId},
      function(d) {
        var r = $.parseJSON(d);
        if (r.success) {
          username.val(r.username);
          website.val(r.website);
          bio.val(r.bio);
        }
        $('#save-response').empty().text(r.message).show().delay(10000).fadeOut(250);
      });
    return false;
  });
  

  $('#bio').keyup(function() {
    var charsLeft = 250-$(this).val().length;
    $('#chars-remaining').text(charsLeft);
    if (charsLeft < 0) {
      $(this).val($(this).val().substring(0, 250));
    }
  });  
  $('#bio').trigger('keyup');


  $('#current-place-input').autocomplete({
		source: function(req,resp) {
      $.post(baseUrl+'places/ajax_autocomplete', {query:req.term},
        function(data) {var r = $.parseJSON(data); resp( $.map(r, function(item) {
						return {
							label: item.name,
							value: item.name,
							id: item.id
						}
					}));
				});
      },
		minLength: 3,
		delay: 200,
		appendTo: '#current-place',
		select: function(event,ui) {
		  $(this).siblings('#current-place-id').val(ui.item.id);
		}
  });
/*
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

*/

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
  if ($('.places_dates').length > 0) {
    $('.places_dates').dynamicForm('#add-place', '#subtract-place', {limit: 10});
  }


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
});


checkNameAvail = function(username) {
  var spinner = $('#username').siblings('img.ajax-spinner');
  spinner.show();
  $.post(baseUrl+'users/check_username_avail', {username:username},
    function(d) {
      spinner.hide();
      var r = $.parseJSON(d);
      if (r.success) {
        $('#username-help').empty().css('color', 'green').text(r.message);
      } else {
        $('#username-help').empty().css('color', 'red').text(r.message);
      }
    });
};