<div id="trail-tab" class="main-tab-content">
  <? foreach ($profile->rsvp_yes_trips as $trip):?>
    <div class="trip">
      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      <? $prefix = ''; $dest_list = '';?>
      <? foreach ($trip->places as $place):?>
        <? $dest_list .= $prefix . '<span class="destination" lat="'.$place->lat.'" lng="'.$place->lng.'">'.
           $place->name.'</span>';?>
        <? $prefix = ', '?>
      <? endforeach;?>
      <?=$dest_list?>
    </div>
  <? endforeach;?>
</div>
