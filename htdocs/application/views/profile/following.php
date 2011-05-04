<div id="following-tab" class="main-tab-content">

  <? if ( ! $profile->following):?>
    <?=$profile->name?> isn't following anyone yet.
  <? endif;?>
  
  <? foreach ($profile->following as $following):?>

  <div class="followitem" id="user-<?=$following->id?>">
    <div class="followitem-avatar-container">
      <a href="<?=site_url('profile/'.$following->id)?>"><img src="<?=static_sub('profile_pics/'.$following->profile_pic)?>" width="48" height="48"/></a>
    </div>
    
    <? if ($following->is_following):?>
      <a href="#" class="unfollow">Unfollow</a>
    <? elseif ($following->id != $user->id):?>
      <a href="#" class="follow">Follow</a>
    <? endif;?>
    
    <div class="followitem-content-container">    
      <div class="followitem-title">
        <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
      </div>    
  
      <div class="followitem-bio"><?=$following->bio?></div>
      <!--<? if (isset($following->place)):?>
      Current location: <a class="place" lat="<?=$following->place->lat?>" lng="<?=$following->place->lng?>" href="#"><?=$following->place->name?></a>
      <? endif;?>-->
    </div>    

    <div style="clear:both"></div> 
       
  </div>
  
  <? endforeach;?>
  
  <? foreach ($profile->following_trips as $following_trip):?>
  
  <div class="followitem">
    <div class="followitem-title">
      <a href="<?=site_url('trips/'.$following_trip->id)?>"><?=$following_trip->name?></a>
    </div>
    <? foreach ($following_trip->places as $place):?>
      <?=$place->name?>
    <? endforeach;?>
    <? foreach ($following_trip->goers as $goer):?>
      <span class="trip-goer">
        <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" width="32" height="32"/></a>
        <a href="<?=site_url('profile/'.$goer->id)?>"><?=$goer->name?></a>
      </span>
    <? endforeach;?>
    
  </div>
  <? endforeach;?>
</div>