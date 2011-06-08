<div id="followers-tab" class="main-tab-content">
  <? if ( ! $place->followers):?>
    <div class="nothingyet-copy">
      <?=$place->name?> doesn't have any followers yet. You can be first! 
      <a href="#" class="follow secondary-follow">Follow</a>
    </div>
  <? endif;?>
  
  <? $prefix='first-item'; foreach ($place->followers as $follower):?>
    <div class="<?=$prefix?> streamitem">
      <? $prefix=''?>
      <div class="big-tab-avatar-container">
        <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="45" height="45"/></a>
      </div>
      <div class="pinched streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
        </div>
        <div class="streamitem-bio"><?=$follower->bio?></div>
      </div>
      <? if(isset($follower->is_following) AND $follower->is_following):?>
        <a href="#" class="unfollow" id="user-<?=$follower->id?>">Unfollow</a>
      <? elseif(!isset($user->id) OR $follower->id != $user->id):?>
        <a href="#" class="follow" id="user-<?=$follower->id?>">Follow</a> 
      <? endif;?>
      <div style="clear:both"></div>
    </div>
  <? endforeach;?>
</div>