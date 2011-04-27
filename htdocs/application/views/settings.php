<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
      'css/settings.css'
    ),
    'js_paths'=>array(
        'js/user/settings.js'
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
  
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
    
    <div id="col-left">
      <div id="e-mail-settings" class="settings-item">
        <div class="settings-item-header">E-mail</div>
        <div class="settings-item-content">
          <div id="current-e-mail-address">e-mail@e-mail.com</div>
          <div id="change-e-mail-address" class="settings-change"><a>Change</a></div>        
        </div>
      </div>
           
      <div id="password-settings" class="settings-item">
        <div class="settings-item-header">Password</div>
        <div class="settings-item-content">
          <div id="password-settings">Password forms (Old password, New Password, confirm new password)</div>
          <div id="change-password" class="settings-change"><a>Change</a></div>        
        </div>
      
      </div>
    
      <div id="notification-settings" class="settings-item">
        <div class="settings-item-header">Notifications</div>
        <div class="settings-item-content">
          <form action="">
            <fieldset>
              
              E-mail me when:
              
              <div class="notification-settings-item">
                <label for="trip-invite">I am invited on a trip</label>
                <input type="checkbox" id="trip-invite" name="trip-invite" 
                  <? if ($settings->trip_invite): ?>checked<? endif;?>
                />
              </div>
              
              <div class="notification-settings-item">              
                <label for="trip-post">Someone posts to one of my trips</label>
                <input type="checkbox" id="trip-post" name="trip-post" 
                  <? if ($settings->trip_post): ?>checked<? endif;?>
                />
              </div>
              
              <div class="notification-settings-item">
                <label for="post-reply">Someone replies to a post I made</label>
                <input type="checkbox" id="post-reply" name="post-reply" 
                  <? if ($settings->post_reply): ?>checked<? endif;?>
                />
              </div>
              
              <div class="notification-settings-item">
                <label for="post-reply">Someone starts following me</label>
                <input type="checkbox" id="#" name="#" 
                  
                /><!--DAVID NEEDED-->
              </div>

              <div class="notification-settings-item">
                <label for="post-reply">Someone responds to my invitation to join one of my trips </label>
                <input type="checkbox" id="post-reply" name="post-reply" 
                  
                /><!--DAVID NEEDED-->
              </div>              
              
              
            </fieldset>
                      
          </form>          
        </div>       
      </div>
      
      <div id="save-settings-container" class="settings-item-content">
        <input type="submit" id="save-settings" class="save-settings-button" name="save-settings" value="Save" />
        <span id="status-text"></span>
      </div>
      
    </div>
    
    <div id="col-right">
    
    
    
    
    
    </div>
    
    
      

    
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
</body>
</head>