<?php
$header_args = array(
    'title' => 'Place | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    stuff goes here
    
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
</body>
</head>