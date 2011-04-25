<div id="following-tab" class="main-tab-content">
  <? foreach ($profile->following as $following):?>
  <div class="following">
    <a href="<?=site_url('profile/'.$following->id)?>"><img src="<?=static_sub('profile_pics/'.$following->profile_pic)?>" width="50" height="50"/></a>
    <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
  </div>
  <? endforeach;?>
  <? foreach ($profile->following_trips as $following_trip):?>
  <div class="following-trip">
    <a href="<?=site_url('trips/'.$following_trip->id)?>"><?=$following_trip->name?></a>
    <? foreach ($following_trip->places as $place):?>
      <?=$place->name?>
    <? endforeach;?>
    <? foreach ($following_trip->goers as $goer):?>
      <span class="trip-goer">
        <a href="<?=site_url('profile/'.$goer->id)?>"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" width="50" height="50"/></a>
        <a href="<?=site_url('profile/'.$goer->id)?>"><?=$goer->name?></a>
      </span>
    <? endforeach;?>
  </div>
  <? endforeach;?>
</div>
