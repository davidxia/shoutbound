<div id="followers-tab" class="main-tab-content">

  <? $prefix='first-item'; foreach ($trip->followers as $follower):?>
  	<div class="<?=$prefix?> streamitem"><? $prefix=''?>

      <? if (isset($follower->is_following) AND $follower->is_following):?>
        <a id="user-<?=$follower->id?>" href="#" class="unfollow">Unfollow</a>
      <? elseif (!isset($user->id) OR $follower->id != $user->id):?>
        <a id="user-<?=$follower->id?>" href="#" class="follow">Follow</a>
      <? endif;?> 
  	
      <div class="streamitem-avatar-container">
        <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" height="25" width="25"/></a>
      </div>         
            
      <div class="narrow streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
        </div>
        <div class="streamitem-bio"><?=$follower->bio?></div>
        <!--<? if (isset($follower->place)):?>
          current location: <a class="place" lat="<?=$follower->place->lat?>" lng="<?=$follower->place->lng?>" href="#"><?=$follower->place->name?></a>
        <? endif;?>-->
      </div>
      <div style="clear:both"></div>
    </div>
  
  <? endforeach;?>
  
  <? if ( ! $trip->followers):?>
    This trip doesn't have any followers yet.
  <? endif;?>
  
</div>
