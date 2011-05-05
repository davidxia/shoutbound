<div id="trail-tab" class="main-tab-content">

  <!-- RSVP AWAITING TRIPS -->
    <? foreach ($user->rsvp_awaiting_trips as $rsvp_awaiting_trip):?>
      <div class="streamitem">
        <span class="streamitem-name">
          <a href="<?=site_url('trips/'.$rsvp_awaiting_trip->id)?>"><?=$rsvp_awaiting_trip->name?></a>
        </span>
        <span class="RSVP-required">(Awaiting response)</span>
        <!--<div class="streamitem-bio">
          <?=$rsvp_awaiting_trip->description?> 
        </div>-->                
        <div class="destinationbar">
          <? foreach ($rsvp_awaiting_trip->places as $place):?>
            <a class="place bar-item" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
            <!--<? if ($place->startdate):?>
              <?=date('n/d/y', $place->startdate)?>
            <? else:?>
              no date set yet
            <? endif;?>-->
            <span class="bullet">&#149</span>                                              
          <? endforeach;?>
        </div>
        
        <div class="goersbar">
          <? foreach ($rsvp_awaiting_trip->goers as $trip_goer):?> 
            <div class="streamitem-avatar-container">                      	                       
              <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$trip_goer->name?>"/>
              </a>
            </div>
          <? endforeach;?>
          <div style="clear:both"></div>
        </div>
                  
      </div>
    <? endforeach;?>
  <!-- RSVP AWAITING TRIPS ENDS -->

  <!-- RSVP YES TRIPS -->
  <? if (empty($user->rsvp_yes_trips)):?>
    <div style="padding:20px;">You don't have any trips yet. Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
  <? else:?>
    <? $first=TRUE; foreach ($user->rsvp_yes_trips as $rsvp_yes_trip):?>
      <div "tripitem-<?=$rsvp_yes_trip->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
        <div class="streamitem-name">
          <a href="<?=site_url('trips/'.$rsvp_yes_trip->id)?>"><?=$rsvp_yes_trip->name?></a>
        </div>
               
        <div class="destinationbar">
          <? foreach ($rsvp_yes_trip->places as $place):?>
            <a class="place destinationbar-item" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?> <span class="subtext">(Dates)</span></a>
            <!--<? if ($place->startdate):?>
              <?=date('n/d/y', $place->startdate)?>
            <? else:?>
              no date set yet
            <? endif;?>-->
            <span class="bullet">&#149</span>
          <? endforeach;?>
        </div>

        <div class="goersbar">
          <? foreach ($rsvp_yes_trip->goers as $goer):?>
            <div class="streamitem-avatar-container bar-item">                       	                       
              <a href="<?=site_url('profile/'.$goer->id)?>">
                <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$goer->name?>"/>
              </a>
            </div>
          <? endforeach;?>
          <div style="clear:both"></div>        
        </div>
        
        <div class="streamitem-bio">
          <?=$rsvp_yes_trip->description?>        
        </div>
        
      </div>
    <? endforeach;?>
  <? endif; ?>
  <!-- RSVP YES TRIPS ENDS -->



  
  
</div>