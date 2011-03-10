<!-- HEADER -->
<div class="header" style="background-color:#4483B1; color:white; height:50px; display:block;">
  <div class="wrapper" style="width:960px; margin:0 auto; position:relative;">
    <h1 style="position:absolute; left:0; top:0px;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" alt="Shoutbound" width="81" height="50" style="display:block;"/></a>
    </h1>
    
  	<a href="<?=site_url('trips/create')?>" style="position: absolute; top:3px; left:300px; display:block; background: transparent url(<?=site_url('images/create_trip_button.png')?>) no-repeat 0 0; width:154px; height:41px;"></a>

    <div class="nav" style="position:absolute; right:0; top:0;">
      <? if ($user->id):?>
        <a href="<?=site_url('home')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Home</a>
        <a href="<?=site_url('settings')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Settings</a>
        <a href="<?=site_url('users/logout')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Logout</a>
      <? else:?>
        <a href="<?=site_url('login')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Login</a>
        <a href="<?=site_url('signup')?>" style="margin-left:20px; text-decoration:none; display:block; float:left; color: white; padding:10px 0; line-height:30px;">Sign Up</a>
      <? endif;?>
    </div>
  </div>
</div><!-- HEADER ENDS -->
