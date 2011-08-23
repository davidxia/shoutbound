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
  
  Enter the email address you use for Shoutbound and we&rsquo;ll send you a link to reset your password.
  
  <form id="pw-reset-form" action="<?=site_url('login/pw_reset')?>" method="post">
    <label for="email">Email address</label>
    <input type="text" id="email" name="email" class="required email"/>
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
  $('#pw-reset-form').validate();


  var options = { 
    success: function(r) {
      $('.ajax-response').find('span').animate({opacity:0}, 200, function(){
        $(this).html(r.message).animate({opacity:1});
        $('#email').val('');
      });
    },
    dataType: 'json'
  };
  $('#pw-reset-form').ajaxForm(options);
});
</script>
</html>