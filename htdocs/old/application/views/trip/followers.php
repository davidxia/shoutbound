<div id="followers-tab" class="main-tab-content">

  <? $prefix='first-item'; foreach ($trip->followers as $follower):?>
  	<div class="<?=$prefix?> streamitem"><? $prefix=''?>
  	
      <div class="big-tab-avatar-container">
        <a href="<? if($follower->username){echo site_url($follower->username);}else{echo site_url('profile/'.$follower->id);}?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" height="50" width="50"/></a>
      </div>         
            
      <div class="pinched streamitem-content-container">
        <div class="streamitem-name">
          <a href="<? if($follower->username){echo site_url($follower->username);}else{echo site_url('profile/'.$follower->id);}?>"><?=$follower->name?></a>
        </div>
        <div class="streamitem-bio"><?=$follower->bio?></div>
        <!--<? if (isset($follower->place)):?>
          current location: <a class="place" lat="<?=$follower->place->lat?>" lng="<?=$follower->place->lng?>" href="#"><?=$follower->place->name?></a>
        <? endif;?>-->
      </div>
      
      <? if (isset($follower->is_following) AND $follower->is_following):?>
        <a id="user-<?=$follower->id?>" href="#" class="unfollow">Unfollow</a>
      <? elseif (!isset($user->id) OR $follower->id != $user->id):?>
        <a id="user-<?=$follower->id?>" href="#" class="follow">Follow</a>
      <? endif;?> 

      <div style="clear:both"></div>
      
    </div>
  
  <? endforeach;?>
  
  <? if ( ! $trip->followers):?>
    <div class="nothingyet-copy">This trip doesn't have any followers yet. You can be first!
      <a href="#" class="follow secondary-follow">Follow</a>
    </div>
  <? endif;?>
  
</div>
