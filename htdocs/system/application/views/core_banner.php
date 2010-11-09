<div id="nn-head">
  
  <div id="nn-logo"><a class="nn-link-home" href="<?=site_url('profile/details');?>">
      <img src="<?=static_url('images/noqnok-logo.jpg')?>"/>
      </a>
  </div>
  
  <div class="nn-fb-banner">
  <? if($user): ?>
  <div class="nn-fb-img right">
      <a class="nn-link-home" href="<?=site_url('profile/details');?>">
          <img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=square" />
      </a>
  </div>
  <div class="nn-fb-text right">Welcome, <?=$user['name']?><br/>
      <a href="<?=site_url('profile/settings')?>" >Settings</a><br/>
      <a href="<?=site_url('user/logout')?>" >Logout</a>

  </div>
    
  <? else: ?>
    You are not logged in!
  <? endif; ?>
  </div>
  
  <div class="clear-both"></div>
  
</div>