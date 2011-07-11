<?php
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=>array(
        'css/common.css',
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
<body class="landing">
<? $this->load->view('templates/content')?>

  <div class="photospread">
    &nbsp;
    <div class="greetingcard">
      <div class="logo">
        <h1>
          Shoutbound
        </h1>
        <h2>
          Discover your next travel adventure
        </h2>
      </div>
      <div class="greeting-content">
        <span>
          SHOUTBOUND delivers the world&rsquo;s most unique and inspiring travel experiences to your inbox.
        </span>
        <div class="buttons">
          <a href="<?=site_url('signup')?>" class="button signup">SIGN UP</a>
          <a href="<?=site_url('login')?>" class="button login">LOGIN</a>
        </div>
      </div>
    </div>
  </div>
    
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
</body>
</html>