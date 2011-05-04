<div id="trail-tab" class="main-tab-content">

  <!-- RSVP AWAITING TRIPS -->
    <? foreach ($user->rsvp_awaiting_trips as $rsvp_awaiting_trip):?>
      <div class="tripitem">
        <span class="trip-listing-name">
          <a href="<?=site_url('trips/'.$rsvp_awaiting_trip->id)?>"><?=$rsvp_awaiting_trip->name?></a>
        </span>
        <span class="RSVP-required">(Awaiting response)</span>
        <div class="trip-listing-description">
          Diana and I are going to check out some national parks for our next vacation.
        </div>                
        <div class="destinationbar">
          <? foreach ($rsvp_awaiting_trip->places as $place):?>
            <a class="place destinationbar-item" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
            <!--<? if ($place->startdate):?>
              <?=date('n/d/y', $place->startdate)?>
            <? else:?>
              no date set yet
            <? endif;?>-->
            <span class="bullet">&#149</span>                                              
          <? endforeach;?>
        </div>
        <? foreach ($rsvp_awaiting_trip->goers as $trip_goer):?>                       	                       
          <a href="<?=site_url('profile/'.$trip_goer->id)?>">
            <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="28" width="28" alt="<?=$trip_goer->name?>"/>
          </a>
        <? endforeach;?>
      </div>
    <? endforeach;?>
  <!-- RSVP AWAITING TRIPS ENDS -->

  <!-- RSVP YES TRIPS -->
  <? if (empty($user->rsvp_yes_trips)):?>
    <div style="padding:20px;">You don't have any trips yet. Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
  <? else:?>
    <? $first=TRUE; foreach ($user->rsvp_yes_trips as $rsvp_yes_trip):?>
      <div "tripitem-<?=$rsvp_yes_trip->id?>" class="<? if($first):?><? echo 'first-tripitem'; $first=FALSE;?><? endif;?> tripitem">
        <div class="trip-listing-name">
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
          <div class="tripitem-avatar-container">                       	                       
            <a href="<?=site_url('profile/'.$goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="30" width="30" alt="<?=$goer->name?>"/>
            </a>
          </div>
        <? endforeach;?>        
        </div>
        
        <div class="tripitem-description">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.        
        </div>
        
      </div>
    <? endforeach;?>
  <? endif; ?>
  <!-- RSVP YES TRIPS ENDS -->



  
  
</div>