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

  <h2>Did you make a mistake?</h2>
    
  <div>
    If you didn't mean to do that, don&rsquo;t worry. Undoing is as simple as clicking this button.
    <form action="<?=site_url('my_account/resubscribe')?>" method="post">
      <input type="submit" value="resubscribe"/>
    </form>
  </div>
  
</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>