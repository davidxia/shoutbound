<?php
$header_args = array(
    'title' => 'Settings | Shoutbound',
    'css_paths'=>array(
        'css/ui-lightness/jquery-ui-1.8.14.custom.css',
    ),
    'js_paths'=>array(
        'js/jquery/jquery.form.js',
        'js/jquery/jquery-ui-1.8.14.custom.min',
        'js/jquery/jquery.validate.min',
        'js/settings.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  <? if($user):?>
  var loggedin = true;
  <? endif;?>
</script>
</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  
  <form id="account-settings-form" action="<?=site_url('my_account/settings')?>" method="post">
    <fieldset class="settings-item">
      <div class="settings-item-name">
        <label for="email" class="settings-item-name" style="line-height:24px; vertical-align:middle;">E-mail</label>
      </div>
      <div class="settings-item-content">
        <input id="email" name="email" type="text" value="<?=$user->email?>" style="width:275px;"/>
        <div class="error-message" style="height:15px;"></div>
      </div>
    </fieldset>
         
    <fieldset class="settings-item">
      <div class="settings-item-name">
        <label for="first_name" class="settings-item-name" style="line-height:24px; vertical-align:middle;">First name</label>
      </div>
      <div class="settings-item-content">
        <input id="first_name" name="first_name" type="text" value="<?=$user->first_name?>" style="width:275px;"/>
        <div class="error-message" style="height:15px;"></div>
      </div>
      <div class="settings-item-name">
        <label for="last_name" class="settings-item-name" style="line-height:24px; vertical-align:middle;">Last name</label>
      </div>
      <div class="settings-item-content">
        <input id="last_name" name="last_name" type="text" value="<?=$user->last_name?>" style="width:275px;"/>
        <div class="error-message" style="height:15px;"></div>
      </div>
      <div class="settings-item-name">
        <label for="gender" class="settings-item-name" style="line-height:24px; vertical-align:middle;">Gender</label>
      </div>
      <div class="settings-item-content">
        <select id="gender" name="gender">
          <option value=""></option>
          <option value="1" <? if($user->gender==1){echo 'selected="selected"';}?>>Male</option>
          <option value="2" <? if($user->gender==2){echo 'selected="selected"';}?>>Female</option>
        </select>
      </div>
      <div class="settings-item-name">
        <label for="income_range" class="settings-item-name" style="line-height:24px; vertical-align:middle;">Income range</label>
      </div>
      <div class="settings-item-content">
        <select id="income_range" name="income_range">
          <option value=""></option>
          <option value="1" <? if($user->income_range==1){echo 'selected="selected"';}?>>Less than $30,000</option>
          <option value="2" <? if($user->income_range==2){echo 'selected="selected"';}?>>$30,000 - $44,999</option>
          <option value="3" <? if($user->income_range==3){echo 'selected="selected"';}?>>$45,000 - $59,999</option>
          <option value="4" <? if($user->income_range==4){echo 'selected="selected"';}?>>$60,000 - $74,999</option>
          <option value="5" <? if($user->income_range==5){echo 'selected="selected"';}?>>$75,000 - $99,999</option>
          <option value="6" <? if($user->income_range==6){echo 'selected="selected"';}?>>$100,000 - $199,999</option>
          <option value="7" <? if($user->income_range==7){echo 'selected="selected"';}?>>$200,000 - $299,999</option>
        </select>
      </div>
      <div class="settings-item-name">
        <label for="bday" class="settings-item-name" style="line-height:24px; vertical-align:middle;">Birthday</label>
      </div>
      <div class="settings-item-content">
        <input id="bday" name="bday" type="text" value="<?=date('m/d/Y', $user->bday)?>" style="width:275px;"/>
        <div class="error-message" style="height:15px;"></div>
      </div>
      <div class="settings-item-name">
        <label for="zipcode" class="settings-item-name" style="line-height:24px; vertical-align:middle;">Zipcode</label>
      </div>
      <div class="settings-item-content">
        <input id="zipcode" name="zipcode" type="text" value="<?=$user->zipcode?>" style="width:275px;"/>
        <div class="error-message" style="height:15px;"></div>
      </div>
    </fieldset>

    <fieldset class="settings-item">
      <div class="settings-item-name">Password</div>
      <div class="settings-item-content">
        <div class="settings-input-container">
          <input type="password" id="old_pw" name="old_pw" style="width:275px; height:20px;"/>
          <label for="old_pw" class="subtext" style="margin-left:10px;">Old password</label>
          <div class="error-message" style="height:15px;"></div>
        </div>
        <div class="settings-input-container">
          <input type="password" id="new_pw" name="new_pw" style="width:275px; height:20px;"/>
          <label for="new_pw" class="subtext" style="margin-left:10px;">New password</label>
          <div class="error-message" style="height:15px;"></div>
        </div>
        <div class="settings-input-container">
          <input type="password" id="conf_new_pw" name="conf_new_pw" style="width:275px; height:20px;"/>
          <label for="conf_new_pw" class="subtext" style="margin-left:10px;">Confirm new password</label>
          <div class="error-message" style="height:15px;"></div>
        </div>
      </div>
    </fieldset>
    
    <div id="save-settings-container">
      <input type="submit" id="save-settings" class="save-settings-button" name="save-settings" value="Save"/>
      <span id="save-response" class="response"></span>
    </div>
  </form>
  
  <div>
    <a href="<?=site_url('my_account/unsubscribe')?>">Unsubscribe</a>
  </div>
    
</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>