$(function() {
  $('#save-settings').click(function() {
    var postData = {
      tripInvite: $('input:checkbox[name="trip-invite"]').attr('checked') ? 1 : 0,
      tripPost: $('input:checkbox[name="trip-post"]').attr('checked') ? 1 : 0,
      postReply: $('input:checkbox[name="post-reply"]').attr('checked') ? 1 : 0
    };
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'settings/ajax_update_settings',
      data: postData,
      success: function(response) {
        var r = $.parseJSON(response);
        $('#status-text').show().text(r.message).delay(1500).fadeOut(1000);
      }
    });
    return false;
  });
});