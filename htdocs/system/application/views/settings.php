<?php
  $header_args = array(
      'css_paths'=>array(
      ),
      'js_paths'=>array(
          'js/user/settings.js'
      )
      
  );
  echo ($this->load->view('core_header', $header_args));
?>
  <!-- JAVASCRIPT CONSTANTS --> 
  <script type="text/javascript">
      var baseUrl = "<?=site_url("")?>";
      var staticUrl = "<?=static_url("")?>";
  </script>
  
</head>

<body>
  Stay in the loop on Shoutbound
  <br/>
  Choose the notification settings that are right for you.
  <br/>
  
  <form action="">
    <fieldset>
    
      I want to receive notifications when someone posts on one of my trips:
      <br/>
      <label for="trip-suggestion">Suggestions</label>
      <input type="checkbox" id="trip-suggestion" name="trip-suggestion" 
      <? if ($settings->trip_suggestion): ?>checked<? endif;?>
      />
      <br/>
      <label for="trip-post">Posts</label>
      <input type="checkbox" id="trip-post" name="trip-post" 
      <? if ($settings->trip_post): ?>checked<? endif;?>
      />
      <br/>
      <label for="trip-reply">Replies</label>
      <input type="checkbox" id="trip-reply" name="trip-reply" 
      <? if ($settings->trip_reply): ?>checked<? endif;?>
      />
      <br/>
      I want to receive notifications when someone replies to a post I make:
      <br/>
      <label for="all-replies">All Replies</label>
      <input type="radio" id="all-replies" name="replies" value="2" 
        <? if ($settings->replies == 2):?>checked<? endif;?>
      />
      <br/>
      <label for="direct-replies">Only Direct Replies</label>
      <input type="radio" id="direct-replies" name="replies" value="1" 
        <? if ($settings->replies == 1):?>checked<? endif;?>
      />
      <br/>
      <label for="no-replies">None</label>
      <input type="radio" id="no-replies" name="replies" value="0" 
        <? if ($settings->replies == 0):?>checked<? endif;?>
      />
    </fieldset>
    
    
    <input type="submit" id="save-settings" name="save-settings" value="Save" />
  
  </form>
  
  <span id="status-text"></span>
    
</body>
</head>