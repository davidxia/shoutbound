<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="position:absolute; top:5px; left:0;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" alt="Shoutbound" width="60" height="35" style="display:block;"/></a>
    </h1>
        
   	<? if ( ! isset($is_landing)):?>
  		<a href="<?=site_url('trips/create')?>" id="create-trip-button" style="position:relative; left:600px; top:3px;">Create new trip</a>
  	<? endif;?>

    <div class="nav" style="position:absolute; right:0; top:0;">    	
      <? if (isset($user->id)):?>
        <a href="<?=site_url('home')?>">Home</a>
        <a href="<?=site_url('profile')?>">Profile</a>
        <a href="<?=site_url('settings')?>">Settings</a>
        <a href="<?=site_url('users/logout')?>">Logout</a>
      <? else:?>
        <a href="<?=site_url('signup')?>">Sign Up</a>
        <a href="<?=site_url('login')?>">Login</a>
      <? endif;?>
    </div>
  </div>
</div><!-- HEADER ENDS -->