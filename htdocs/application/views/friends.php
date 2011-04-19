<?php
$header_args = array(
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

</head>
<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
        
      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

  <? $this->load->view('footer')?>
  
<script type="text/javascript">
  $('#accept-request').click(function() {
    var friendId = $(this).parent().attr('uid')
    var postData = {
      friendId: friendId
    };
    
    $.ajax({
      type: 'POST',
      url: '<?=site_url('friends/ajax_accept_request')?>',
      data: postData,
      success: function(data) {
        if (data==1) {
          $('div[uid="'+friendId+'"]').remove();
        } else {
          alert('something broken, tell David');
        }
      }
    });
    return false;
  });
</script>
</body>
</head>