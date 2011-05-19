<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="display:inline;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('static/images/logo_header.png')?>" alt="Shoutbound" width="52" height="30"/></a>
    </h1>

   	<? if ( ! isset($is_landing)):?>
  		<a href="<?=site_url('trips/create')?>" id="create-trip-button" style="position:absolute; left:595px; top:0;">+ New trip</a>
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