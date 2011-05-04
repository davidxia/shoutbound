<div id="followers-tab" class="main-tab-content">

  <? $first=TRUE; foreach ($trip->followers as $follower):?>
  	<div id="user-<?=$follower->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> followitem">
      <div class="followitem-avatar-container">
        <a href="<?=site_url('profile/'.$follower->id)?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" height="48" width="48"/></a>
      </div>     
      
      <? if ($follower->is_following):?>
        <a href="#" class="unfollow">Unfollow</a>
      <? elseif ($follower->id != $user->id):?>
        <a href="#" class="follow">Follow</a>
      <? endif;?>       
            
      <div class="followitem-content-container">
        <div class="followitem-title">
          <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
        </div>
        <div class="followitem-bio"><?=$follower->bio?></div>
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
