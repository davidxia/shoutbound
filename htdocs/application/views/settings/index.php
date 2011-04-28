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
  
    <div id="top-bar">
      Manage your Shoutbound account.    
    </div>
        
    <div id="col-left">
    
      <div id="left-content-container">
      
        <ul id="main-tabs"><!--DAVID NEEDED TO MAKE TABBING WORK-->
          <li><a href="#account">Account</a></li>
          <li><a href="#profile">Profile</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="account-tab" class="main-tab-content main-tab-default">
    
              <div id="e-mail-settings" class="settings-item">
                <div class="settings-item-name">E-mail</div>
                <div class="settings-item-content">
                  <div id="current-e-mail-address">e-mail@e-mail.com</div>
                  <div id="change-e-mail-address" class="settings-change"><a>Change</a></div>        
                </div>
              </div>
                   
              <div id="password-settings" class="settings-item">
                <div class="settings-item-name">Password</div>
                <div class="settings-item-content">
                  <div id="password-settings"><!--DAVID NEEDED TO MAKE THESE ACTUALL WORK : ) -->
                    <input type="text" id="url" style="width:275px; height:20px; margin-bottom:8px;"/>
                    <span class="subtext">Old password</span>
                    <input type="text" id="url" style="width:275px; height:20px; margin-bottom:8px;"/>
                    <span class="subtext">New password</span>
                    <input type="text" id="url" style="width:275px; height:20px; margin-bottom:8px;"/>
                    <span class="subtext">Confirm new password</span>                  
                  </div>
                  <div id="change-password" class="settings-change"><a>Change</a></div><!--DAVID - #password-settings div should be hidden by default, clicking "CHANGE" should reveal them.  "SAVE" button below should save it"-->        
                </div>              
              </div>
            
              <div id="notification-settings" class="settings-item">
                <div class="settings-item-name">E-mail me when:</div>
                <div class="settings-item-content">
                  <form action="">
                    <fieldset>
                      
                      <div class="notification-settings-item">
                        <input type="checkbox" id="follow-user" name="follow-user" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="follow-user">Someone starts following me</label>
                      </div>

                      <div class="notification-settings-item">
                        <input type="checkbox" id="follow-trip" name="follow-trip" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="follow-trip">Someone starts following one of my trips</label>
                      </div>
                      
                      <div class="notification-settings-item">
                        <input type="checkbox" id="follow-create" name="follow-create" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="follow-create">Someone I follow creates a trip</label>
                      </div>                      

                      <div class="notification-settings-item">
                        <input type="checkbox" id="follow-post" name="follow-post" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="follow-post">Someone I follow posts something</label>
                      </div>

                      <div class="notification-settings-item">
                        <input type="checkbox" id="trip-post" name="trip-post" 
                          <? if ($settings->trip_post): ?>checked<? endif;?>
                        />              
                        <label for="trip-post">Someone posts something on one of my trips</label>
                      </div>
        
                      <div class="notification-settings-item">
                        <input type="checkbox" id="post-reply" name="post-reply" 
                          <? if ($settings->post_reply): ?>checked<? endif;?>
                        />
                        <label for="post-reply">Someone comments on a post I made</label>
                      </div>
                      
                      <div class="notification-settings-item">                
                        <input type="checkbox" id="trip-invite" name="trip-invite" 
                          <? if ($settings->trip_invite): ?>checked<? endif;?>
                        />
                        <label for="trip-invite">I am invited to join a trip</label>
                      </div>

                      <div class="notification-settings-item">                
                        <input type="checkbox" id="sent-invites" name="sent-invites" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="got-RSVP">Invitations are sent to join one of my trips</label>
                      </div>
                      
                      <div class="notification-settings-item">                
                        <input type="checkbox" id="got-RSVP" name="got-RSVP" 
                          
                        /><!--DAVID NEEDED-->
                        <label for="got-RSVP">Someone responds to an invitation to join one of my trips</label>
                      </div>

                      <div id="restore-default-notifications" class="settings-change"><a>Restore defaults</a></div><!--DAVID NEEDED--> 
                                         
                    </fieldset>
                              
                  </form>          
                </div>       
              </div>
              
              <div id="save-settings-container">
                <input type="submit" id="save-settings" class="save-settings-button" name="save-settings" value="Save" /><!--DAVID NEEDED - THIS BUTTON NEEDS TO SAVE ALL THE FIELDS-->
                <span id="status-text"></span><!--DAVID NEEDED - THIS SHOULD ALSO APPEAR WHEN YOU CLICK THE BUTTON ON THE EDIT PROFILE PAGE-->
              </div>
              
            </div><!--ACCOUNT TAB END-->
              
           </div><!--MAIN TAB END-->   
      
     </div><!--LEFT CONTENT CONTAINER--> 
      
    </div><!--LEFT COLUMN END-->
       
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
</body>
</head>