<?php
$header_args = array(
    'title' => 'Press | Shoutbound',
    'css_paths'=>array(
        'css/common.css'
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

  <h2>press page</h2>
    
  
  <p><br />Page rendered in {elapsed_time} seconds</p>
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

<? $this->load->view('templates/footer')?>

</body>
</html>