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

  <div>
    <a href="<?=site_url('my_account/unsubscribe')?>">Unsubscribe</a>
  </div>
    
  

</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>