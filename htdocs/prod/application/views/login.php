<?php
$header_args = array(
    'title' => 'Login | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('templates/core_header', $header_args);
?>

</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>
  
  <div>
    <h2 style="font-size:24px;">Login</h2>
    <? if(isset($invalid_login)):?>
      <div>
        invalid email or password
      </div>
    <? endif;?>
    <form id="login-form" action="<?=site_url('login')?>" method="post" style="margin-top:30px">
      <div style="margin:10px 0;">
        <label style="font-size:18px;" for="email">Email</label>
      </div>
      <div>
        <input type="text" id="email" name="email" style="width:250px;"/>
      </div>
      <div style="margin:10px 0;">
        <label style="font-size:18px;" for="password">Password</label>
      </div>
      <div>
        <input type="password" id="password" name="password" style="width:250px;"/>
      </div>
      <div style="margin:10px 0;">
        <input type="submit" name="login" value="Login" class="button"/>
      </div>
    </form>
    
    <div><a href="<?=site_url('login/pw_reset')?>">Forgot your password?</a></div>
  </div>
  
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>