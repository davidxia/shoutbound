<div id="trail-tab" class="main-tab-content">
  <? if ( ! $profile->rsvp_yes_trips):?>
    <?=$profile->name?> doesn't have any trips yet. <a href="#">Suggest some</a>.
  <? endif;?>
  <? foreach ($profile->rsvp_yes_trips as $trip):?>
    <div class="trip">
      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      <? $prefix = ''; $dest_list = '';?>
      <? foreach ($trip->places as $place):?>
        <? $dest_list .= $prefix . '<span class="place" lat="'.$place->lat.'" lng="'.$place->lng.'">'.
           $place->name.'</span>';?>
        <? $prefix = ', '?>
      <? endforeach;?>
      <?=$dest_list?>
    </div>
  <? endforeach;?>

  <div style="border-top:1px solid #BABABA;">
    Places <?=$profile->name?> has been:<br/>
    <? if ($user AND $is_self):?>
      <a href="<?=site_url('profile/edit')?>">Show off</a> where you've been.
    <? elseif ( ! $profile->places):?>
      <?=$profile->name?> hasn't listed any places yet.
    <? endif;?>
    <? foreach ($profile->places as $place):?>
      <span class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>"><?=$place->name?></span>
    <? endforeach;?>
  </div>
</div>