<!-- HEADER -->
<div class="header" style="background-color:#44749D; color:white; font-size:14px; height:50px; display:block;">
  <div class="wrapper" style="width:960px; margin:0 auto; position:relative;">
    <h1 style="position:absolute; left:0; top:0px;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" alt="Shoutbound" width="81" height="50" style="display:block;"/></a>
    </h1>
    
    <? if ( ! $is_landing):?>
    	<a href="<?=site_url('trips/create')?>" id="create-trip-button">CREATE A TRIP</a>
    <? endif;?>
    
    <div class="nav" style="position:absolute; right:0; top:0;">
      <? if ($user->id):?>
        <a href="<?=site_url('home')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Home</a>
        <a href="<?=site_url('profile')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Profile</a>
        <a href="<?=site_url('settings')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Settings</a>
        <a href="<?=site_url('users/logout')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Logout</a>
      <? else:?>
        <a href="<?=site_url('login')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Login</a>
        <a href="<?=site_url('signup')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; padding:15px 0; color: white; line-height:20px; font-size:14px;">Sign Up</a>
      <? endif;?>
    </div>
  </div>
</div><!-- HEADER ENDS -->
