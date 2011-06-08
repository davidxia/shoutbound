<div id="trips-tab" class="main-tab-content">  
  <? foreach ($user->onboarding_trips as $trip):?>
    <div class="streamitem">
      <div class="big-tab-avatar-container">
        <img src="<?=static_sub('images/trip_icon.png')?>" width="50" height="50">
      </div>
      <div class="pinched streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
        </div>
        <div class="destinationbar">
          Going to:
          <? foreach ($trip->places as $place):?>
            <span class="place fakelink" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></span>
          <? endforeach;?>
        </div>
        <div class="streamitem-bio"><?=$trip->description?></div>           
        <div class="goersbar">
          <? foreach ($trip->goers as $goer):?>
            <div class="bar-item"> 
              <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="25" height="25" alt="<?=$goer->name?>"/></a>
            </div>      
          <? endforeach;?>
          <div style="clear:both"></div>
        </div>
      </div>
      <a class="follow" id="trip-<?=$trip->id?>">Follow</a>
      <div style="clear:both"></div>
    </div>
  <? endforeach;?>
</div>

