<div id="followers-tab" class="main-tab-content">
  <? if ( ! $place->followers):?>
    <?=$place->name?> doesn't have any followers yet. You can be the first.
  <? endif;?>
  <? $prefix='first-item'; foreach ($place->followers as $follower):?>
    <div class="<?=$prefix?> streamitem">
      <? $prefix=''?>
      <? if(isset($follower->is_following) AND $follower->is_following):?>
        <a href="#" class="unfollow" id="user-<?=$follower->id?>">Unfollow</a>
      <? elseif(!isset($user->id) OR $follower->id != $user->id):?>
      <a href="#" class="follow" id="user-<?=$follower->id?>">Follow</a> 
      <? endif;?>
      
      <div class="streamitem-avatar-container">
        <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="25" height="25"/></a>
      </div>

      <div class="narrow streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
        </div>
        <div class="streamitem-bio"><?=$follower->bio?></div>
      </div>

    </div>
  <? endforeach;?>
</div>