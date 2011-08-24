<?php
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
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
    
  <div>
    <h2 style="font-size:24px;">Sign Up</h2>
    <form id="signup-form" action="<?=site_url('signup')?>" method="post" style="margin-top:30px">
      <div style="margin:10px 0;">
        <label style="font-size:18px;" for="signup_email">Email</label>
      </div>
      <div>
        <input type="text" id="signup_email" name="signup_email" style="width:250px;"/>
      </div>
      <div style="margin:10px 0;">
        <label style="font-size:18px;" for="signup_password">Password</label>
      </div>
      <div>
        <input type="password" id="signup_password" name="signup_password" style="width:250px;"/>
      </div>
      <div style="margin:10px 0;">
        <input type="submit" name="signup" value="SIGN UP" class="button signup"/>
      </div>
    </form>  
  </div>

  <div id="signup-response"><span></span></div>

</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>