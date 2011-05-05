<div id="followers-tab" class="main-tab-content">
  <? if ( ! $profile->followers):?>
    <?=$profile->name?> doesn't have any followers yet.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->followers as $follower):?>

  	<div id="user-<?=$follower->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">

    <? if ($follower->is_following):?>
      <a href="#" class="unfollow">Unfollow</a>
    <? elseif ($follower->id != $user->id):?>
      <a href="#" class="follow">Follow</a>
    <? endif;?>

    <div class="streamitem-avatar-container">
      <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="25" height="25"/></a>
    </div>
    
    <div class="narrow streamitem-content-container">

      <div class="streamitem-name">
        <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
      </div>
      <div class="streamitem-bio"><?=$follower->bio?></div>
      <!--<? if (isset($follower->place)):?>
        current location: <a class="place" lat="<?=$follower->place->lat?>" lng="<?=$follower->place->lng?>" href="#"><?=$follower->place->name?></a>
      <? endif;?>-->      
      <div style="clear:both"></div>
    </div>
    
  </div>
  
  <? endforeach;?>
</div>

