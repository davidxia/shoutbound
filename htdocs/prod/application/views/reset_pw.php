<?php
$header_args = array(
    'title' => 'Password Reset | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/jquery/jquery.validate.min',
        'js/jquery/jquery.form.js',
        'js/signup.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>

</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>
  
  Reset your password below:
  
  <form id="reset-pw-form" action="<?=site_url('login/reset_pw')?>" method="post">
    <label for="password">New password</label>
    <input type="password" id="password" name="password"/>
    <label for="password_confirm">Confirm new password</label>
    <input type="password" id="password_confirm" name="password_confirm"/>
    <input type="hidden" name="user_id" value="<?=$user_id?>"/>
    <input type="hidden" name="hash" value="<?=$hash?>"/>
    <input type="submit" val="Submit"/>
  </form>
  
  <div class="ajax-response"><span></span></div>
    
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
<script type="text/javascript">
$(function(){
  $('#reset-pw-form').validate({
    rules: {
      password: {
        required: true,
        minlength: 4
      },
      password_confirm: {
        required: true,
        equalTo: '#password'
      }
    }
  });
  

  var options = { 
    success: function(r) {
      if (!r.success){
        $('.ajax-response').find('span').animate({opacity:0}, 200, function(){
          $(this).html(r.message).animate({opacity:1});
        });
      } else {
        window.location = r.redirect;
      }
    },
    dataType: 'json'
  };
  $('#reset-pw-form').ajaxForm(options);
});
</script>
</html>