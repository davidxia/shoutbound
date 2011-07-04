<?php
$header_args = array(
    'title' => 'My Account | Shoutbound',
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

  <h2>my account page</h2>
  
  <div>
    My favorites:
  </div>
  
  <div>
    <a href="<?=site_url('my_account/invite')?>">Invite friends</a>
  </div>
    
  <div>
    <a href="<?=site_url('my_account/settings')?>">My account settings</a>
  </div>  
  
  <p><br />Page rendered in {elapsed_time} seconds</p>
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

<? $this->load->view('templates/footer')?>

</body>
</html>