<div id="trail-tab" class="main-tab-content">
  <? if ( ! $profile->rsvp_yes_trips):?>
    <?=$profile->name?> doesn't have any trips yet.
  <? endif;?>
  
  <? $first=TRUE; foreach ($profile->rsvp_yes_trips as $trip):?>
    <div id="tripitem-<?=$trip->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
    
      <a href="#" class="follow">this needs fixing</a>
      
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
      
      <!--<div class="streamitem-bio">
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