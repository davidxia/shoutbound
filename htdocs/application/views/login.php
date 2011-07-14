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
    <h2>Login</h2>
    <? if(isset($invalid_login)):?>
      <div>
        invalid email or password
      </div>
    <? endif;?>
    <form action="<?=site_url('login')?>" method="post">
      <label for="email">Email</label>
      <input type="text" id="email" name="email"/>
      <label for="password">Password</label>
      <input type="password" id="password" name="password"/>
      <input type="submit" name="login" value="Login"/>
    </form>
    
    <div><a href="<?=site_url('login/pw_reset')?>">Forgot your password?</a></div>
  </div>
  
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>