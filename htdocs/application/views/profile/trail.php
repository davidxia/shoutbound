<div id="trail-tab" class="main-tab-content">
  <? if ( ! $profile->rsvp_yes_trips):?>
    <?=$profile->name?> doesn't have any trips yet. <a href="#">Suggest some</a>.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->rsvp_yes_trips as $trip):?>
    <div id="tripitem-<?=$trip->id?>" class="<? if($first):?><? echo 'first-tripitem'; $first=FALSE;?><? endif;?> tripitem">
    
      <a href="#" class="follow-button">Follow</a>
      <div class="trip-listing-name">
        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      </div>
            
      <div class="trip-listing-description">
      Diana and I are going to check out some national parks for our next vacation.
      </div>

      <div class="destinationbar">
        <? $prefix = ''; $dest_list = '';?>
        <? foreach ($trip->places as $place):?>
          <? $dest_list .= $prefix . '<a class="place destinationbar-item" lat="'.$place->lat.'" lng="'.$place->lng.'">'.
             $place->name.'</a>';?>
          <? $prefix = ' <span class="bullet">&#149</span> '?>
        <? endforeach;?>
        <?=$dest_list?>
      </div>

    </div>
  <? endforeach;?>

  <!--<div style="border-top:1px solid #BABABA;">
    Places <?=$profile->name?> has been:<br/>
    <? if ($user AND $is_self):?>
      <a href="<?=site_url('settings/profile')?>">Show off</a> where you've been.
    <? elseif ( ! $profile->places):?>
      <?=$profile->name?> hasn't listed any places yet.
    <? endif;?>
    <div>
    <? $is_current = 'Current location: '; foreach ($profile->places as $place):?>
      <?=$is_current?><span class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>"><?=$place->name?></span>
      <br/>
      <? $is_current = ''?>
    <? endforeach;?>
    </div>-->
    
  </div>
</div>