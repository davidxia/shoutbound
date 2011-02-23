var create = {};

create.showCreateDialog = function() {
  $.ajax({
    url: baseUrl+'users/ajax_get_logged_in_status',
    success: function(response){
      var r = $.parseJSON(response);
      if (r.loggedin) {
        $.ajax({
          url: baseUrl+'trips/ajax_trip_create_panel',
          success: create.displayCreatePanel
        });
      } else {
        alert('youre not logged in!');
      }
    }
  });
}


create.displayCreatePanel = function(response) {
  var r = $.parseJSON(response);
  $('#div_to_popup').empty();
  $('#div_to_popup').append(r['data']);
  $('#div_to_popup').bPopup();
  $('#trip-create-confirm').bind('click', create.confirmCreate);
  $('#trip-create-cancel').bind('click', function() {
    $('#div_to_popup').bPopup().close();
  });
}


create.confirmCreate = function() {
  var tripName = $('#trip-name').val();
  var postData = {tripName: tripName};
    
  if (tripName) {
    $.ajax({
      type: 'POST',
      url: baseUrl+'trips/ajax_trip_create',
      data: postData,
      success: function(response) {
        var r = $.parseJSON(response);
        window.location = baseUrl+'trips/details/'+r['tripid'];
      }
    });
  } else {
    alert('Please name your trip! You will be glad you did.')
  }
}


$(document).ready(function() {
  $('#create-trip').click(function() {
    create.showCreateDialog();
    return false;
  });
});