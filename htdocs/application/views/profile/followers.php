<div id="followers-tab" class="main-tab-content">
  <? foreach ($profile->followers as $follower):?>
  <div class="follower">
    <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="50" height="50"/></a>
    <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
  </div>
  <? endforeach;?>
</div>