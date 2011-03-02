<!-- HEADER -->
<div id="header" style="height:60px; padding: 10px 0 10px;">
  <div id="logo" style="float:left;">
    <a class="home" href="<?=site_url('home')?>" style="font-size:26px; display:block; height:60px; width:95px; background:url('<?=site_url('images/logo_header.png')?>'); text-indent:-9999px;">Shoutbound</a>
  </div>
  
  <div style="background-color:#4483B1; border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; float:right; width:830px; border: 1px solid #8BB5C8;">
  	<div style="float:left; margin-left:200px; padding-top:5px;">
    	<a href="<?=site_url('trips/create')?>" style="font-size:26px;"><img src="<?=site_url('images/create_trip_button.png')?>" /></a>
    </div>
    
    <ul id="navigation" style="float:right; line-height:60px;">
      <li style="float:right; margin-right:10px;"><a href="<?=site_url('users/logout')?>" style="color:white; text-decoration:none;">Logout</a></li>
      <li style="float:right; margin-right:10px;"><a href="<?=site_url('profile/settings')?>" style="color:white; text-decoration:none;">Settings</a></li>
      <li style="float:right; margin-right:10px;"><a href="<?=site_url('home')?>" style="color:white; text-decoration:none;">Home</a></li>
    </ul>
  </div>
</div><!-- HEADER ENDS -->
