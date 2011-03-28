<?php
$header_args = array(
    'title' => 'Edit profile | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css'
    ),
    'js_paths'=>array(
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
    )
);

$this->load->view('core_header', $header_args);
?>
  
</head>

<body style="background-color:white">

  <?=$this->load->view('header')?>
  
  <div class="wrapper" style="background:white;">
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
    
      <div>
        <div id="status-message">Select an image file on your computer (4MB max):</div>
        <a href="#" id="file_upload" name="file_upload" type="file">SELECT FILES</a>
        <div id="custom-queue"></div>
      </div>

      
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <?=$this->load->view('footer')?>
  
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'       : '<?=site_url('static/js/uploadify/uploadify.swf')?>',
    'script'         : '<?=site_url('profile/profile_pic_uploadify')?>',
    'scriptData'     : {'uid':<?=$user->id?>},
    'cancelImg'      : '<?=site_url('images/cancel.png')?>',
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'auto'           : true,
    'sizeLimit'      : 32000000,
    'fileExt'        : '*.jpg;*.gif;*.png',
    'fileDesc'       : 'Image Files'
  });
});
</script>

</body>
</head>