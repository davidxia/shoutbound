<div id="trips-tab" class="main-tab-content">
<? foreach ($place->trips as $trip):?>
  <div>
    <div class="trip-name">
      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
    </div>
    
    <div>
    <? foreach ($trip->places as $place):?>
      <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>" title="<?=$trip->name?>"><?=$place->name?></a>
      <? if ($place->startdate):?>
        <?=date('n/d/y', $place->startdate)?>
      <? else:?>
        no date set yet
      <? endif;?>
    <? endforeach;?>
    </div>
    
    <div class="trip-description"><?=$trip->description?></div>
    <? foreach ($trip->goers as $goer):?>
      <a href="<?=site_url('profile/'.$goer->id)?>">
        <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$goer->name?>"/>
      </a>
    <? endforeach;?>
  </div>
<? endforeach;?>
</div>