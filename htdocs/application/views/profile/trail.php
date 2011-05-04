<div id="trail-tab" class="main-tab-content">
  <? if ( ! $profile->rsvp_yes_trips):?>
    <?=$profile->name?> doesn't have any trips yet.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->rsvp_yes_trips as $trip):?>
    <div id="tripitem-<?=$trip->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> tripitem">
    
      <a href="#" class="follow">this needs fixing</a>
      
      <div class="trip-listing-name">
        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      </div>
      
      <div class="destinationbar">
        <? $prefix = ''; $dest_list = '';?>
        <? foreach ($trip->places as $place):?>
          <? $dest_list .= $prefix . '<a href="'.site_url('places/'.$place->id).'" class="place destinationbar-item" lat="'.$place->lat.'" lng="'.$place->lng.'">'.
             $place->name.'</a><span class="subtext">(Dates)</span>';?>
          <? $prefix = ' <span class="bullet">&#149</span> '?>
        <? endforeach;?>
        <?=$dest_list?>
      </div>
      
      <div class="goersbar">      
        <? foreach ($trip->goers as $goer):?>
          <div class="tripitem-avatar-container">                       	                       
            <a href="<?=site_url('profile/'.$goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="30" width="30" alt="<?=$goer->name?>"/>
            </a>
          </div>
          <? endforeach;?>
      </div>
      
      <!--<div class="tripitem-description">
        <?=$trip->description?>     
      </div>-->

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