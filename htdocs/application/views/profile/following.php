<div id="following-tab" class="main-tab-content">

  <? if (!($profile->following_users OR $profile->following_trips OR $profile->following_places)):?>
    <?=$profile->name?> isn't following anyone yet.
  <? endif;?>
  
  <? $prefix='first-item'; foreach($profile->following_users as $following_user):?>
  <div class="<?=$prefix?> streamitem">
    <? $prefix=''?>
    <? if (isset($following_user->is_following) AND $following_user->is_following):?>
      <a href="#" class="unfollow" id="user-<?=$following_user->id?>">Unfollow</a>
    <? elseif (!isset($user->id) OR $following_user->id != $user->id):?>
      <a href="#" class="follow" id="user-<?=$following_user->id?>">Follow</a>
    <? endif;?>

    <div class="streamitem-avatar-container">
      <a href="<? if($following_user->username){echo site_url($following_user->username);}else{echo site_url('profile/'.$following_user->id);}?>"><img src="<?=static_sub('profile_pics/'.$following_user->profile_pic)?>" width="25" height="25"/></a>
    </div>
    
    <div class="narrow streamitem-content-container">    
      <div class="streamitem-name">
        <a href="<? if($following_user->username){echo site_url($following_user->username);}else{echo site_url('profile/'.$following_user->id);}?>"><?=$following_user->name?></a>
      </div>    
  
      <div class="streamitem-bio"><?=$following_user->bio?></div>
      <!--<? if (isset($following_user->current_place)):?>
      Current location: <a class="place" lat="<?=$following_user->current_place->lat?>" lng="<?=$following_user->current_place->lng?>" href="#"><?=$following_user->current_place->name?></a>
      <? endif;?>-->
    </div>    

    <div style="clear:both"></div> 
     
  </div>
  <? endforeach;?>
  
  
  <? foreach ($profile->following_trips as $following_trip):?>
  <div class="<?=$prefix?> streamitem">
    <? if (!isset($following_trip->rsvp) OR $following_trip->rsvp == 0):?>
      <a href="#" class="follow" id="trip-<?=$following_trip->id?>">Follow</a>
    <? elseif (isset($following_trip->rsvp) AND $following_trip->rsvp == 3):?>
      <a href="#" class="unfollow" id="trip-<?=$following_trip->id?>">Unfollow</a>
    <? endif;?>  
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('trips/'.$following_trip->id)?>"><img src="<?=static_sub('images/trip_icon.png')?>" width="25" height="25"/></a>
    </div>
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('trips/'.$following_trip->id)?>"><?=$following_trip->name?></a>
      </div>
      <div class="destinationbar">
        <? foreach ($following_trip->places as $place):?>
          <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
          <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
        <? endforeach;?>
      </div>
      
      <div class="goersbar">
        <? foreach ($following_trip->goers as $goer):?>
          <div class="streamitem-avatar-container bar-item"> 
            <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="25" height="25" alt="<?=$goer->name?>"/></a>
          </div>      
        <? endforeach;?>
        <div style="clear:both"></div>
      </div>
    </div>
  </div>
  <? endforeach;?>
  
  
  <? foreach ($profile->following_places as $place):?>
  <div class="<?=$prefix?> streamitem">
    <? if (isset($place->is_following) AND $place->is_following):?>
      <a href="#" class="unfollow" id="place-<?=$place->id?>">Unfollow</a>
    <? else:?>
      <a href="#" class="follow" id="place-<?=$place->id?>">Follow</a>
    <? endif;?>    
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('places/'.$place->id)?>"><img src="<?=static_sub('images/place_icon.png')?>" width="25" height="25"/></a>
    </div>
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
      </div>
      <div class="streamitem-bio">Place bio here. Lorem ipsum and all that good stuff.  New York is a cool place, but Advocate Harbor is better.</div>
    </div>
  </div>
  <? endforeach;?>
  
</div>