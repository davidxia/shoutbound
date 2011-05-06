<div id="following-tab" class="main-tab-content">

  <? if ( ! $profile->following):?>
    <?=$profile->name?> isn't following anyone yet.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->following as $following):?>
  <div class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">

    <? if (isset($following->is_following) AND $following->is_following):?>
      <a href="#" class="unfollow" id="user-<?=$following->id?>">Unfollow</a>
    <? elseif (!isset($user->id) OR $following->id != $user->id):?>
      <a href="#" class="follow" id="user-<?=$following->id?>">Follow</a>
    <? endif;?>

    <div class="streamitem-avatar-container">
      <a href="<?=site_url('profile/'.$following->id)?>"><img src="<?=static_sub('profile_pics/'.$following->profile_pic)?>" width="25" height="25"/></a>
    </div>
    
    <div class="narrow streamitem-content-container">    
      <div class="streamitem-name">
        <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
      </div>    
  
      <div class="streamitem-bio"><?=$following->bio?></div>
      <!--<? if (isset($following->place)):?>
      Current location: <a class="place" lat="<?=$following->place->lat?>" lng="<?=$following->place->lng?>" href="#"><?=$following->place->name?></a>
      <? endif;?>-->
    </div>    

    <div style="clear:both"></div> 
     
  </div>
  <? endforeach;?>
  
  
  <? foreach ($profile->following_trips as $following_trip):?>
  <div class="streamitem">
    <? if (isset($following_trip->rsvp) AND $following_trip->rsvp == 0):?>
      <a href="#" class="follow" id="trip-<?=$following_trip->id?>">Follow</a>
    <? elseif (isset($following_trip->rsvp) AND $following_trip->rsvp == 3):?>
      <a href="#" class="unfollow" id="trip-<?=$following_trip->id?>">Unfollow</a>
    <? endif;?>  

    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('trips/'.$following_trip->id)?>"><?=$following_trip->name?></a>
      </div>
      <div class="destinationbar">
        <? foreach ($following_trip->places as $place):?>
          <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
          <span class="subtext"><? if ($place->startdate){echo date('F j, Y', $place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
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
  <div class="streamitem">
  
    <? if (isset($place->is_following) AND $place->is_following):?>
      <a href="#" class="unfollow" id="place-<?=$place->id?>">Unfollow</a>
    <? else:?>
      <a href="#" class="follow" id="place-<?=$place->id?>">Follow</a>
    <? endif;?>    
  
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
      </div>
      <div class="streamitem-bio">Place bio here. Lorem ipsum and all that good stuff.  New York is a cool place, but Advocate Harbor is better.</div>
    </div>
  </div>
  <? endforeach;?>
  
</div>