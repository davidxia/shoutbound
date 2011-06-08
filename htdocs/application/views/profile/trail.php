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
      
      <div class="narrow streamitem-content-container"> 
        <div class="streamitem-name">
          <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
        </div>
  
        <div class="destinationbar">
          Going to:  
          <? $prefix = ''; foreach ($trip->places as $place):?>
            <?=$prefix?>
            <a href="<?=site_url('places/'.$place->id)?>" class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>">
              <?=$place->name?>
            </a>
  <!--           <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span> -->
  <!--           <? $prefix = ' <span class="bullet" style="display:none">&#149</span> '?> -->
          <? endforeach;?>
        </div>
  
        <div class="streamitem-bio">
          <?=$trip->description?>     
        </div>
  
        <div class="goersbar">
          <? foreach ($trip->goers as $goer):?>
            <div class="bar-item">                       	                       
              <a href="<? if($goer->username){echo site_url($goer->username);}else{echo site_url('profile/'.$goer->id);}?>">
                <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$goer->name?>"/>
              </a>
            </div>
          <? endforeach;?>
          <div style="clear:both"></div>
        </div>          

    </div>
    </div>
  
      <? endforeach;?>
</div>