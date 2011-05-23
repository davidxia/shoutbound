<div id="trail-tab" class="main-tab-content">
  <? if ( ! $profile->rsvp_yes_trips):?>
    <?=$profile->name?> doesn't have any trips yet.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->rsvp_yes_trips as $trip):?>
    <div id="tripitem-<?=$trip->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
    
      <? if (!isset($trip->rsvp) OR $trip->rsvp == 0):?>
        <a href="#" class="follow" id="trip-<?=$trip->id?>">Follow</a>
      <? elseif (isset($trip->rsvp) AND $trip->rsvp == 3):?>
        <a href="#" class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a>
      <? endif;?>
       
      <div class="streamitem-name">
        <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      </div>
      
      <div class="destinationbar">
        <? $prefix = ''; foreach ($trip->places as $place):?>
          <?=$prefix?>
          <a href="<?=site_url('places/'.$place->id)?>" class="place destinationbar-item" lat="<?=$place->lat?>" lng="<?=$place->lng?>">
            <?=$place->name?>
          </a>
          <span class="subtext"><? if($place->startdate){echo date('F j, Y',$place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
          <? $prefix = ' <span class="bullet">&#149</span> '?>
        <? endforeach;?>
      </div>
      
      <div class="goersbar">      
        <? foreach ($trip->goers as $goer):?>
          <div class="streamitem-avatar-container bar-item">                       	                       
            <a href="<?=site_url('profile/'.$goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$goer->name?>"/>
            </a>
          </div>
        <? endforeach;?>
        <div style="clear:both"></div>
      </div>
      
      <div class="streamitem-bio">
        <?=$trip->description?>     
      </div>

    </div>
  <? endforeach;?>

  <div style="border-top:1px solid #BABABA;">
    Places <?=$profile->first_name?> has been:<br/>
    <? if ($user AND $is_self AND count($profile->places)<5):?>
      <a href="<?=site_url('settings/profile')?>">Show off</a> where you've been.
    <? elseif ( ! $profile->places):?>
      <?=$profile->name?> hasn't listed any places yet.
    <? endif;?>
    <div>
    <? foreach ($profile->places as $place):?>
     <div>
     <span class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" title="<?=$place->name?>">
         <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a><? if($place->admin1){echo ', '.$place->admin1;}if($place->country){echo ', '.$place->country;}?>
       </span>
       <? if($place->timestamp):?>
         <?=date('F Y', $place->timestamp)?>
       <? endif;?>
     </div>
    <? endforeach;?>
    </div>
    
  </div>
</div>