<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="display:inline;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('static/images/160x_50_sb_logo.png')?>" alt="Shoutbound" width="160" height="50"/></a>
    </h1>

    <? if (isset($user->id)):?>
  		<a href="<?=site_url('trips/create')?>" id="create-trip-button" style="position:absolute; left:595px; top:0;">+ New trip</a>
      <div class="nav" style="position:absolute; right:0; top:0;">    	
        <a href="<?=site_url('home')?>">Home</a>
        <a href="<?=site_url('profile')?>">Profile</a>
        <a href="<?=site_url('settings')?>">Settings</a>
        <a href="<?=site_url('users/logout')?>">Logout</a>        
      </div>      
    <? else:?>
      <div style="float:right; margin-right:5px; font-size:12px;">
        <span id="login-error"></span>
        <form id="login-form" action="">
          <fieldset>
            <div style="float:left; margin-right:10px;">
              <label for="email" style="float:left; color:white; margin-right:5px;font-size:12px;">Email:</label>        
              <input type="text" name="email" id="email" style="width:125px; font-size:12px;"/>                    
            </div>
            <div style="float:left; margin-right:5px;">
              <label for="password" style="float:left; color:white; margin-right:5px;font-size:12px;">Password:</label>
              <input type="password" name="password" id="password" style="width:125px; font-size:12px;"/>
            </div>
          <fieldset>
          <button type="submit" id="login-submit" class="blue-button">Login</button>
        </form>
      </div>      
    <? endif;?>
        
  </div>
</div><!-- HEADER ENDS -->