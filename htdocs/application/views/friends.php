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

<body style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">

  <?=$this->load->view('header')?>
  
  <div class="wrapper" style="margin:0 auto; width:960px;">
    <div class="content" style="padding-bottom:80px;">
      
      You have friend requests pending from
      <br/>
      <? foreach ($pending_friends as $pending_friend):?>
        <div uid="<?=$pending_friend->id?>"><?=$pending_friend->name?> <a id="accept-request" href="#">Accept</a> <a id="ignore-request" href="#">Ignore</a></div>
      <? endforeach;?>
      
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->

  <?=$this->load->view('footer')?>
  
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

