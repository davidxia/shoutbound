<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/user/settings.js'
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url('')?>";
  var staticUrl = "<?=static_url('')?>";
</script>
  
</head>

<body style="background-color:#1B272C;">

  <?=$this->load->view('header')?>
  
  <div class="wrapper" style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
      
      <form action="">
        <fieldset>
          E-mail me when:
          <br/><br/>
          <label for="trip-invite">someone invites me on a trip</label>
          <input type="checkbox" id="trip-invite" name="trip-invite" 
            <? if ($settings->trip_invite): ?>checked<? endif;?>
          />
          <br/>
          <label for="trip-post">someone posts on my trips</label>
          <input type="checkbox" id="trip-post" name="trip-post" 
            <? if ($settings->trip_post): ?>checked<? endif;?>
          />
          <br/>
          <label for="post-reply">replies to a post I made</label>
          <input type="checkbox" id="post-reply" name="post-reply" 
            <? if ($settings->post_reply): ?>checked<? endif;?>
          />
        </fieldset>
        
        
        <input type="submit" id="save-settings" name="save-settings" value="Save" />
      
      </form>
      
      <span id="status-text"></span>
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <?=$this->load->view('footer')?>

</body>
</head>