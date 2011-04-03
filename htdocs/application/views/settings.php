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
  var baseUrl = "<?=site_url()?>";
</script>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
      
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
        
        <br>
        
        <input type="submit" id="save-settings" class="blue-button" name="save-settings" value="Save" />
      
      </form>
      
      <span id="status-text"></span>
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <? $this->load->view('footer')?>

</body>
</head>