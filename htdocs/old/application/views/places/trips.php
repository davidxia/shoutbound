<div id="trips-tab" class="main-tab-content">
<? if(!$place->trips):?>
  <div class="nothingyet-copy">There are no trips to <?=$place->name?> yet. You should <a href="<?=site_url('trips/create')?>">create one</a>!</div>
<? endif;?>
<? foreach ($place->trips as $trip):?>

  <div class="streamitem"> 
    <div class="big-tab-avatar-container">
      <a href="<?=site_url('trips/'.$trip->id)?>">
        <img src="<?=static_sub('images/trip_icon.png')?>" width="50" height="50"/></a>
    </div>
    <div class="pinched streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      </div>      
      <div class="destinationbar">
        Going to:
        <? foreach ($trip->places as $place):?>
          <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>" title="<?=$trip->name?>"><?=$place->name?></a>
    <!--       <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span> -->
        <? endforeach;?>
      </div>         
      <div class="streamitem-bio"><?=$trip->description?></div>      
      <div class="goersbar">
        <? foreach ($trip->goers as $goer):?>
          <a href="<?=site_url('profile/'.$goer->id)?>">
            <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$goer->name?>"/>
          </a>
        <? endforeach;?>
      </div>
    </div>    
    <? if (!isset($trip->rsvp) OR $trip->rsvp == 0):?>
      <a href="#" class="follow" id="trip-<?=$trip->id?>">Follow</a>
    <? elseif (isset($trip->rsvp) AND $trip->rsvp == 3):?>
      <a href="#" class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a>
    <? endif;?>
    <div style="clear:both"></div>  
  </div>
    
<? endforeach;?>
</div>