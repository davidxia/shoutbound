$(function(){
  if ($('#bday').length>0){
    $('#bday').datepicker();
  }

  if ($('#account-settings-form').length>0){
    $('#account-settings-form').validate({
      rules: {
        email: {
          required: true,
          email: true
        }
      }
    });


    var options = { 
      success: showResponse,
      dataType: 'json'
    };
    $('#account-settings-form').ajaxForm(options);
  }
  
  function showResponse(r){ 
    if (r.correct_pw){
      $('#old_pw').val('');
      $('#new_pw').val('');
      $('#conf_new_pw').val('');
    }
    $('#save-response').empty().text(r.message).show().delay(10000).fadeOut(250);
  }

});