<div id="followers-tab" class="main-tab-content">
  <? if ( ! $profile->followers):?>
    <?=$profile->name?> doesn't have any followers yet. You can be the <a href="#">first</a>.
  <? endif;?>
  <? foreach ($profile->followers as $follower):?>
  <div class="follower">
    <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="50" height="50"/></a>
    <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
    <? if (isset($follower->place)):?>
      current location: <a class="place" lat="<?=$follower->place->lat?>" lng="<?=$follower->place->lng?>" href="#"><?=$follower->place->name?></a>
    <? endif;?>
  </div>
  <? endforeach;?>
</div>