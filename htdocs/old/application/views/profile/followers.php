<div id="followers-tab" class="main-tab-content">
  <? if ( ! $profile->followers):?>
    <div class="nothingyet-copy"><?=$profile->name?> doesn't have any followers yet. You can be first! 
      <a href="#" class="follow secondary-follow">Follow</a>    
    </div>
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->followers as $follower):?>
  	<div class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
      <div class="big-tab-avatar-container">
        <a href="<? if($follower->username){echo site_url($follower->username);}else{echo site_url('profile/'.$follower->id);}?>"><img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" width="50" height="50"/></a>
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
        <a href="#" class="unfollow" id="user-<?=$follower->id?>">Unfollow</a>
      <? elseif (!isset($user->id) OR $follower->id != $user->id):?>
        <a href="#" class="follow" id="user-<?=$follower->id?>">Follow</a>
      <? endif;?>
      <div style="clear:both"></div>   
    </div>
  <? endforeach;?>
</div>

