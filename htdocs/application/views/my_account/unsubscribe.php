<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('templates/core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  <? if($user):?>
  var loggedin = true;
  <? endif;?>
</script>
</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  <h2>Unsubscribe From Shoutbound</h2>
    
  <div>
    If you unsubscribe, your email address <?=$user->email?> will no longer receive our awesome stuff. And we will be sad :(
    <form action="<?=site_url('my_account/unsubscribe')?>" method="post">
      <input type="submit" value="unsubscribe"/>
    </form>
  </div>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>