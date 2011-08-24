<div id="related_trips-tab" class="main-tab-content">

  <? if ( ! $trip->related_trips):?>
    <div class="nothingyet-copy">There are no trips related to this one. Are you thinking of a similar adventure? <a href="<?=site_url('trips/create')?>">Create a trip</a> for it!
  <? endif;?>

  <? $prefix='first-item'; foreach ($trip->related_trips as $trip):?>
  	<div id="trip-<?=$trip->id?>" class="<?=$prefix?> streamitem"><? $prefix=''?>
      <div class="big-tab-avatar-container">
        <a href="<?=site_url('trips/'.$trip->id)?>"><img src="<?=static_sub('images/trip_icon.png')?>" height="50" width="50"/></a>
      </div>                           
      <div class="pinched streamitem-content-container">      
        <div class="streamitem-name">
          <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
        </div>        
        <div class="destinationbar">
          Going to:
          <? foreach ($trip->places as $place):?>
            <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
<!--
            <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
          <? endforeach;?>
-->
        </div>
        <div class="streamitem-bio">
          <?=$trip->description?>     
        </div>
        <div class="goersbar">
          <? foreach ($trip->goers as $goer):?>
            <div class="bar-item"> 
              <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="25" height="25" alt="<?=$goer->name?>"/></a>
            </div>      
          <? endforeach;?>
        </div>  	
      </div>
      <? if (isset($trip->is_following) AND $trip->is_following):?>
        <a href="#" class="unfollow">Unfollow</a>
      <? elseif (!isset($user->id) OR !$trip->is_following):?>
        <a href="#" class="follow">Follow</a>
      <? endif;?> 
      <div style="clear:both"></div>     
    </div>
  <? endforeach;?>  
</div>
