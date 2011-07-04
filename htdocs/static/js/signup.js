$(function() {
  if ($('#signup-form').length>0){
    $('#signup-form').validate({
      rules: {
        signup_email: {
          required: true,
          email: true
        },
        signup_password: {
          required: true,
          minlength: 4
        }
      },
      messages: {
        signup_email: {
          required: 'We promise not to spam you : )',
          email: 'Oops, was there a typo?'
        },
        signup_password: {
          required: 'Passwords are your friend.',
          minlength: 'Passwords should be at least 4 characters.'
        }
      },
  /*
      errorPlacement: function(error, ele) {
        error.appendTo(ele.siblings('.error-message'));
      }
  */
    });


    var options = { 
      success: showResponse,
      dataType: 'json'
    };
    $('#signup-form').ajaxForm(options);
  }
  function showResponse(r){ 
    if (!r.success){
      $('#signup-response').find('span').animate({opacity:0}, 200, function(){
        $(this).text(r.message).animate({opacity:1});
      });
    } else {
      window.location = r.redirect;
    }
  }
  
  if ($('#bday').length>0){
    $('#bday').datepicker();
  }
});