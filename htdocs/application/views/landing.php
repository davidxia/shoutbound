<?php
$header_args = array(
    'title' => 'Shoutbound',
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

  <h1>Shoutbound</h1>
  <h2>Discover your next travel adventure</h2>
  
  <div>SHOUTBOUND delivers the world&rsquo;s most unique and inspiring travel experiences to your inbox.</div>
  
  <form id="signup-form" action="<?=site_url('signup')?>" method="post">
    <label for="signup_email">Email</label>
    <input type="text" id="signup_email" name="signup_email"/>
    <label for="signup_password">Password</label>
    <input type="password" id="signup_password" name="signup_password"/>
    <input type="submit" value="SIGN UP"/>
  </form>
  
  <div id="signup-response"><span></span></div>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>