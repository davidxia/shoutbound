<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="display:inline;">
      <a href="<?=site_url('/')?>">
        <img src="<?=site_url('static/images/160x_50_sb_logo.png')?>" alt="Shoutbound" width="160" height="40"/>
      </a>
    </h1>
    
    <? if(isset($user->id) AND !isset($is_onboarding)):?>
      <div id="search-box" style="position:absolute;top:0;left:200px;">
        <input id="searchbar" type="text" style="height:22px;width:250px;"/>
      </div>

  		<a href="<?=site_url('trips/create')?>" id="create-trip-button" style="position:absolute; left:595px; top:0;">+ New trip</a>
      <div class="nav" style="position:absolute; right:0; top:0;">    	
        <a href="<?=site_url('home')?>">Home</a>
        <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>">Profile</a>
        <a href="<?=site_url('settings')?>">Settings</a>
        <a href="<?=site_url('users/logout')?>">Logout</a>        
      </div>      
    <? elseif(isset($user->id) AND isset($is_onboarding)):?>
      <div class="nav" style="position:absolute; right:0; top:0;">    	
        <a href="<?=site_url('users/logout')?>">Logout</a>        
      </div>      
    <? elseif(!isset($is_onboarding)):?>
      <div style="float:right; margin-right:5px; font-size:12px;position:relative;">
        <span id="login-error" style="position:absolute;left:-150px;color:white;"></span>
        <form id="login-form" action="">
          <fieldset>
            <div style="float:left; margin-right:10px;">
              <label for="email" style="float:left; color:white; margin-right:5px;font-size:12px;">Email</label>        
              <input type="text" name="login_email" id="login_email" style="width:150px;height:22px;"/>                    
            </div>
            <div style="float:left; margin-right:5px;">
              <label for="password" style="float:left; color:white; margin-right:5px;font-size:12px;">Password</label>
              <input type="password" name="login_password" id="login_password" style="width:150px;height:22px;"/>
            </div>
          </fieldset>
          <input id="login-submit" type="submit" val="submit"/>
        </form>
      </div>
      
      <script type="text/javascript">
        $(function() {
          $('#login-submit').click(function() {      
            $.post('<?=site_url('login/ajax_email_login')?>', {email:$('#login_email').val(), password:$('#login_password').val()},
              function(d) {
                var r = $.parseJSON(d);
                if (r.success) {
                  window.location = '<?=site_url()?>';
                } else {
                  $('#login-error').empty().text(r.message).show().delay(10000).fadeOut(250);
                  $()
                }
              });
            return false;
          });
        });
      </script>
    <? endif;?>
        
  </div>
</div><!-- HEADER ENDS -->