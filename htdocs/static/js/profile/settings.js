function initialize(){
    $('#save-button').click(save_button_clicked);
}

function save_button_clicked() {
    var postData = {
        trip_suggestion: $('input:checkbox[name="trip_suggestion"]').attr('checked') ? 1 : 0,
        trip_post: $('input:checkbox[name="trip_post"]').attr('checked') ? 1 : 0,
        trip_reply: $('input:checkbox[name="trip_reply"]').attr('checked') ? 1 : 0,
        replies: $('input:radio[name="replies"]:checked').val()
    };
    $.ajax({url: Constants['siteUrl']+'profile/ajax_update_settings',
            type: 'POST',
            data: postData,
            success: function() {
                $('#status_text').show().text('Settings Updated!').delay(1500).fadeOut(1000);
            }
    });
    return false;
}

$(document).ready(initialize);
