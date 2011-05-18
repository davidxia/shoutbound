<?php
$header_args = array(
    'title' => 'History | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url()?>";
</script>
  
</head>

<body>
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
    
    <?=$geodata?>
    
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <? $this->load->view('footer')?>

</body>
</head>