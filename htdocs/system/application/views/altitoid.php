<?php
$header_args = array(
    'title' => 'Uploadify | Shoutbound',
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

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url('')?>";
</script>

<style type="text/css"> 
.uploadifyQueueItem {
  background-color: #FFFFFF;
  border: none;
  border-bottom: 1px solid #E5E5E5;
  font: 11px Verdana, Geneva, sans-serif;
  height: 50px;
  margin-top: 0;
  padding: 10px;
  width: 350px;
}
.uploadifyError {
  background-color: #FDE5DD !important;
  border: none !important;
  border-bottom: 1px solid #FBCBBC !important;
}
.uploadifyQueueItem .cancel {
  float: right;
}
.uploadifyQueue .completed {
  color: #C5C5C5;
}
.uploadifyProgress {
  background-color: #E5E5E5;
  margin-top: 10px;
  width: 100%;
}
.uploadifyProgressBar {
  background-color: #0099FF;
  height: 3px;
  width: 1px;
}
#custom-queue {
  border: 1px solid #E5E5E5;
  height: 213px;
  margin-bottom: 10px;
  width: 370px;
}
</style> 

</head>

<body style="background-color:white">

  <?=$this->load->view('header')?>
  
<body>
  <div class="wrapper" style="background:white;">
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
      
      <div>
        <div id="status-message">Upload yo files</div>
        <input id="file_upload" name="file_upload" type="file" />
        <div id="custom-queue"></div>
      </div>
            
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

  
  <?=$this->load->view('footer')?>
  
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'       : '<?=site_url('static/js/uploadify/uploadify.swf')?>',
    'script'         : '<?=site_url('altitoid/uploadify')?>',
    'cancelImg'      : '<?=site_url('images/cancel.png')?>',
    'auto'           : true,
    'multi'          : true,
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'simUploadLimit' : 3,
    'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
    'onAllComplete'  : function(event,data) {
      $('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
    }
  });
});
</script>      

</body>
</head>