<div id="nn-head" class="container_12">
  
  <div id="nn-logo" class="grid_2">
      <a class="nn-link-home" href="<?=site_url('profile/details');?>">
          <img src="<?=static_url('images/noqnok-logo.jpg')?>"/>
      </a>
  </div>
    
  <div id="nn-fb-banner" class="grid_3 push_7">
  <? if($user): ?>
      <a class="nn-link-home" href="<?=site_url('profile/details');?>">Home</a>
      <a href="<?=site_url('profile/settings')?>">Settings</a>
      <a href="<?=site_url('user/logout')?>">Logout</a>
  <? else: ?>
    You are not logged in!
  <? endif; ?>
  </div>
  
  <div class="clear"></div>
  
</div>