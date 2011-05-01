<div id="trail-tab" class="main-tab-content">
  <!-- RSVP YES TRIPS -->
  <span style="font-size:16px; padding-left:10px; font-weight:bold; color:black;">RSVP YES TRIPS</span>
  <? if (empty($user->rsvp_yes_trips)):?>
    <div style="padding:0px 0px 20px 20px;">You don't have any trips yet. Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
  <? else:?>
    <? foreach ($user->rsvp_yes_trips as $rsvp_yes_trip):?>
      <div class="home-users-trip" style="margin:10px; border-bottom:1px solid #BABABA;">
        <div>
          <a href="<?=site_url('trips/'.$rsvp_yes_trip->id)?>"><?=$rsvp_yes_trip->name?></a>
        </div>
        <div>
          <? foreach ($rsvp_yes_trip->places as $place):?>
            <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="#"><?=$place->name?></a>
            <? if ($place->startdate):?>
              <?=date('n/d/y', $place->startdate)?>
            <? else:?>
              no date set yet
            <? endif;?>
          <? endforeach;?>
        </div>
        <? foreach ($rsvp_yes_trip->goers as $goer):?>                       	                       
          <a href="<?=site_url('profile/'.$goer->id)?>">
            <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$goer->name?>"/>
          </a>
        <? endforeach;?>
      </div>
    <? endforeach;?>
  <? endif; ?>
  <!-- RSVP YES TRIPS ENDS -->
  
  <!-- RSVP AWAITING TRIPS -->
	<span style="font-size:16px; padding-left:10px; font-weight:bold;color:black;">RSVP AWAITING</span>
	<? if ( ! $user->rsvp_awaiting_trips):?>
    <div style="margin-left:20px; padding-bottom:20px;">Find exciting trips by seeing what others are up to.</div>
  <? else:?>
    <? foreach ($user->rsvp_awaiting_trips as $rsvp_awaiting_trip):?>
      <div class="home-friends-trip" style="margin:10px; border-bottom:1px solid #BABABA;">
        <div>
          <a href="<?=site_url('trips/'.$rsvp_awaiting_trip->id)?>"><?=$rsvp_awaiting_trip->name?></a>
        </div>
        <div>
          <? foreach ($rsvp_awaiting_trip->places as $place):?>
            <a class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" href="#"><?=$place->name?></a>
            <? if ($place->startdate):?>
              <?=date('n/d/y', $place->startdate)?>
            <? else:?>
              no date set yet
            <? endif;?>                                              
          <? endforeach;?>
        </div>
        <? foreach ($rsvp_awaiting_trip->goers as $trip_goer):?>                       	                       
          <a href="<?=site_url('profile/'.$trip_goer->id)?>">
            <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$trip_goer->name?>"/>
          </a>
        <? endforeach;?>
      </div>
    <? endforeach;?>
  <? endif;?>
  <!-- RSVP AWAITING TRIPS ENDS -->
</div>