<div id="trips-tab" class="main-tab-content">
  
  <? foreach ($trips as $trip):?>
  <div class="streamitem">
    <a class="unfollow" id="place-<?=$trip->id?>">Unfollow</a>
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('trips/'.$trip->id)?>">
        <img src="<?=static_sub('images/trip_icon.png')?>" width="25" height="25">
      </a>
    </div>
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      </div>
      <div class="destinationbar">
        <? foreach ($trip->places as $place):?>
          <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
          <span class="subtext"><? if ($place->startdate){echo date('F j, Y', $place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
        <? endforeach;?>
      </div>
      
      <div class="goersbar">
        <? foreach ($trip->goers as $goer):?>
          <div class="streamitem-avatar-container bar-item"> 
            <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="25" height="25" alt="<?=$goer->name?>"/></a>
          </div>      
        <? endforeach;?>
        <div style="clear:both"></div>
      </div>
      </div>
    </div>
  </div>
  <? endforeach;?>
</div>