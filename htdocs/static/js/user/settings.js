function save_settings() {
  var postData = {
    trip_suggestion: $('input:checkbox[name="trip-suggestion"]').attr('checked') ? 1 : 0,
    trip_post: $('input:checkbox[name="trip-post"]').attr('checked') ? 1 : 0,
    trip_reply: $('input:checkbox[name="trip-reply"]').attr('checked') ? 1 : 0,
    replies: $('input:radio[name="replies"]:checked').val()
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'settings/ajax_update_settings',
    data: postData,
    success: function() {
      $('#status-text').show().text('Settings updated!').delay(1500).fadeOut(1000);
    }
  });
  return false;
}

$(document).ready(function() {
  $('#save-settings').click(save_settings);
});
