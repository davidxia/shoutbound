<?php
$header_args = array(
    'title' => 'Edit Profile | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/user/settings.js'
    )
);

$this->load->view('core_header', $header_args);
?>
  
</head>

<body style="background-color:white">

  <?=$this->load->view('header')?>
  
  <div class="wrapper" style="background:white;">
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
    
    <?=$user->name?>
      
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <?=$this->load->view('footer')?>

</body>
</head>