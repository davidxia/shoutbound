<?php
$header_args = array(
    'title' => 'Uploadify | Shoutbound',
    'css_paths'=>array(
        'css/uploadify.css'
    ),
    'js_paths'=>array(
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/jquery/validate.min.js',
        'js/jquery/popup.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css"> 
#file_upload {
  color:white;
  display:block;
  height: 30px;
  width: 120px;
  line-height: 30px;
  text-align:center;
  font-size: 13px;
  text-decoration:none;
  /*
  background:-webkit-gradient(linear, left top, left bottom, from(#E0E0E0), to(#888888));
  background:-moz-linear-gradient(top, #E0E0E0 , #888888);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#E0E0E0', endColorstr='#888888');
  */
  background: #555;
  border: 1px solid #686868;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
}
#file_upload:hover {
  /*
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#ffad32), to(#ff8132));
  background: -moz-linear-gradient(top,  #ffad32,  #ff8132);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#ff8132');
  */
}
#file_upload:active {
  /*
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#ff8132), to(#ffad32));
  background: -moz-linear-gradient(top,  #ff8132,  #ffad32);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff8132', endColorstr='#ffad32');
  */
}
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

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

    <div id="div-to-popup" style="background-color:white; display:none;"></div>      
  
    <div>
      <div id="status-message">Upload yo files</div>
      <div>tip: hold down shift or control to select multiple files</div>
      <a href="#" id="file_upload" name="file_upload" type="file">SELECT FILES</a>
      <div id="custom-queue"></div>
    </div>
        
    <? foreach ($uploads as $upload):?>
      <!--<img src="<?=site_url('images/uploads').'/'.$upload->path?>" width="<?=$upload->width?>" height="<?=$upload->height?>"/>-->
      <a href="<?=site_url('images/uploads').'/'.$upload->path?>"><?=$upload->path?></a>
      <br/>
    <? endforeach;?>
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  
    
  <? $this->load->view('footer')?>
  
<script type="text/javascript">
$(document).ready(function() {
  <? if ($user->id):?>
  $('#file_upload').uploadify({
    'uploader'       : '<?=site_url('static/js/uploadify/uploadify.swf')?>',
    'script'         : '<?=site_url('altitoid/uploadify')?>',
    'scriptData'     : {'uid':<?=$user->id?>},
    //'buttonImg'      : 'http://www.uploadify.com/wp-content/uploads/rollover-button.png',
    //'rollover'       : true,
    'cancelImg'      : '<?=site_url('images/cancel.png')?>',
    'multi'          : true,
    'queueID'        : 'custom-queue',
    'removeCompleted': false,
    'simUploadLimit' : 3,
    'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
    'onAllComplete'  : function(event,data) {
      $('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
    },
    'auto'           : true,
    'sizeLimit'      : 80000000
  });
  <? else:?>
  $('#file_upload').click(function(){
    showLoginSignupDialog();
    return false;
  });
  <? endif;?>
});

function showLoginSignupDialog() {
  $.ajax({
    url: '<?=site_url('users/login_signup')?>',
    success: function(r) {
      var r = $.parseJSON(r);
      $('#div-to-popup').empty();
      $('#div-to-popup').append(r.data);
      $('#div-to-popup').bPopup();
    }
  });
}


function loginSignupSuccess() {
  $('#div-to-popup').bPopup().close();
  location.reload(true);
}

</script>      

</body>
</head>