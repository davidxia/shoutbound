<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
      'css/settings.css'
    ),
    'js_paths'=>array(
        'js/jquery/validate.min.js',
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

<div id="sticky-footer-wrapper">
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
    <div id="top-bar">
      Manage your Shoutbound account.
    </div>
        
    <div id="col-left">
    
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li class="active"><a href="<?=site_url('settings')?>">Account</a></li>
          <li><a href="<?=site_url('settings/profile')?>">Profile</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="account-tab" class="main-tab-content main-tab-default">
            <form id="account-settings-form">
              <fieldset class="settings-item">
                <div class="settings-item-name">
                  <label for="email" class="settings-item-name" style="line-height:24px; vertical-align:middle;">E-mail</label>
                </div>
                <div class="settings-item-content">
                  <input id="email" name="email" type="text" value="<?=$user->email?>" style="width:275px;"/>
                  <div class="error-message" style="height:20px;"></div>
                </div>
              </fieldset>
                   
              <fieldset class="settings-item">
                <div class="settings-item-name">Password</div>
                <div class="settings-item-content">
                  <div class="settings-input-container">
                    <input type="password" id="old_pw" name="old_pw" style="width:275px; height:20px;"/>
                    <label for="old_pw" class="subtext" style="margin-left:10px;">Old password</label>
                    <div class="error-message" style="height:20px;"></div>
                  </div>
                  <div class="settings-input-container">
                    <input type="password" id="new_pw" name="new_pw" style="width:275px; height:20px;"/>
                    <label for="new_pw" class="subtext" style="margin-left:10px;">New password</label>
                    <div class="error-message" style="height:20px;"></div>
                  </div>
                  <div class="settings-input-container">
                    <input type="password" id="conf_new_pw" name="conf_new_pw" style="width:275px; height:20px;"/>
                    <label for="conf_new_pw" class="subtext" style="margin-left:10px;">Confirm new password</label>
                    <div class="error-message" style="height:20px;"></div>
                  </div>
                </div>
              </fieldset>
              
              <fieldset class="settings-item">
                <div class="settings-item-name">E-mail me when</div>
                <div class="settings-item-content">
                  <? foreach ($settings as $setting):?>
                  <div>
                    <input type="checkbox" id="<?=$setting->name?>" name="<?=$setting->name?>" <? if (isset($user->settings[$setting->id]) AND $user->settings[$setting->id]) echo 'checked';?>/>
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
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('footer')?>
<script type="text/javascript">
  $(function() {
    $('#save-settings').click(function() {
      if ($('#account-settings-form').valid()) {
        var postData = {
          email: $('#email').val(),
          oldPw: $('#old_pw').val(),
          newPw: $('#new_pw').val(),
          confNewPw: $('#conf_new_pw').val(),
          <? $prefix = ''; $settings_list='';?>
          <? foreach ($settings as $setting):?>
            <? $settings_list .= $prefix . $setting->name.': $(\'input:checkbox[name="'.$setting->name.'"]\').attr(\'checked\') ? 1 : 0'?>
            <? $prefix = ', '?>
          <? endforeach;?>
          <?=$settings_list?>
        };
        
        $.post(baseUrl+'settings/ajax_save_settings', postData,
          function(d) {
            var r = $.parseJSON(d);
            $('#old_pw').val('');
            $('#new_pw').val('');
            $('#conf_new_pw').val('');
            if (r.emailTaken) {
              $('#email').siblings('.error-message').append('<label class="error">Email is already taken.</label>');
            }
            if (r.pwIncorrect) {
              $('#old_pw').siblings('.error-message').append('<label class="error">Password incorrect</label>');
            }
            if (!r.emailTaken && !r.pwIncorrect) {
              $('#save-response').empty().text(r.response).show().delay(10000).fadeOut(250);
            }
          });
      }        
      return false;
    });
  });
  

  $(function() {
    $('#account-settings-form').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        new_pw: {
          minlength: 4
        },
        conf_new_pw: {
          equalTo: '#new_pw'
        }
      },
      messages: {
        email: {
          required: 'We promise not to spam you.',
          email: 'Nice try, enter a valid email.'
        },
        old_pw: {
          required: 'You need to verify your old password.'
        },
        new_pw: {
          required: 'You gotta have a password.',
          minlength: 'At least 4 characters.'
        },
        conf_new_pw: {
          equalTo: 'Passwords must match.'
        }
      },
      errorPlacement: function(error, element) {
        element.siblings('.error-message').empty();
        error.appendTo(element.siblings('.error-message'));
      }
    });
  });
</script>
</body>
</head>