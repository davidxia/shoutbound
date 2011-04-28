<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
      'css/settings.css'
    ),
    'js_paths'=>array(
        'js/settings/index.js'
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
      Manage your Shoutbound account
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
            <form>
              <fieldset class="settings-item">
                <label for="email" class="settings-item-name" style="line-height:24px; vertical-align:middle;">E-mail</label>
                <input id="email" type="text" value="<?=$user->email?>" style="margin-left:15px;"/>
              </fieldset>
                   
              <fieldset class="settings-item">
                <div class="settings-item-name">Password</div>
                <div class="settings-item-content">
                  <input type="password" id="old_pw" name="old_pw" style="width:275px; height:20px; margin-bottom:8px;"/>
                  <label for="old_pw" class="subtext">Old password</label>
                  <input type="password" id="new_pw" name="new_pw" style="width:275px; height:20px; margin-bottom:8px;"/>
                  <label for="new_pw" class="subtext">New password</label>
                  <input type="password" id="conf_new_pw" name="conf_new_pw" style="width:275px; height:20px; margin-bottom:8px;"/>
                  <label for="conf_new_pw" class="subtext">Confirm new password</label>
                </div>
              </fieldset>
              
              <fieldset class="settings-item">
                <div class="settings-item-name">E-mail me when</div>
                <div class="settings-item-content">
                  <? foreach ($settings as $setting):?>
                  <div>
                    <input type="checkbox" id="<?=$setting->name?>" name="<?=$setting->name?>" <? if ($user->settings[$setting->id]) echo 'checked';?>/>
                    <label for="<?=$setting->name?>"><?=$setting->description?></label>
                  </div>
                  <? endforeach;?>
                </div>       
              </fieldset>

              <div id="save-settings-container">
                <input type="submit" id="save-settings" class="save-settings-button" name="save-settings" value="Save"/>
                <span id="save-response"></span>
              </div>
            </form>
          </div><!--ACCOUNT TAB END-->
              
        </div><!--MAIN TAB END-->   
      </div><!--LEFT CONTENT CONTAINER--> 
    </div><!--LEFT COLUMN END-->
       
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
<script type="text/javascript">
  $(function() {
    $('#save-settings').click(function() {
      var postData = {
        <? $prefix = ''; $settings_list='';?>
        <? foreach ($settings as $setting):?>
          <? $settings_list .= $prefix . $setting->name.': $(\'input:checkbox[name="'.$setting->name.'"]\').attr(\'checked\') ? 1 : 0'?>
          <? $prefix = ', '?>
        <? endforeach;?>
        <?=$settings_list?>
      };
      
      $.post(baseUrl+'settings/ajax_save_settings', postData,
        function(d) {
          console.log(d);
          $('#save-response').empty().text(d).show().delay(1500).fadeOut(250);
        });
        
      return false;
    });
  });
</script>
</body>
</head>