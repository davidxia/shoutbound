<!-- TRAIL TAB -->
<div id="trail-tab" class="main-tab-content">
  <!-- USERS TRIPS -->
  <div id="user-trips" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gary; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; margin-bottom:20px;">
  	<div style="background-color:#C6D4E1; line-height:30px; height:30px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
  		<span style="font-size:16px; padding-left:10px; font-weight:bold; color:black;">Trips</span>
  	</div>
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
              <?=$place->name?>
              <? if ($place->startdate):?>
                <?=date('n/d/y', $place->startdate)?>
              <? else:?>
                no date set yet
              <? endif;?>               
            <? endforeach;?>
          </div>
          <? foreach ($rsvp_yes_trip->goers as $trip_goer):?>                       	                       
            <a href="<?=site_url('profile/'.$trip_goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$trip_goer->name?>"/>
            </a>
          <? endforeach;?>
        </div>
      <? endforeach;?>
    <? endif; ?>
  </div><!-- USERS TRIPS ENDS -->
  
  <!-- FRIENDS TRIPS -->
  <div id="home-friends-trips" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gary; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8;">
  	<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
  		<span style="font-size:16px; padding-left:10px; font-weight:bold;color:black;">Following</span>
  	</div>
  	<? if ( ! $user->following_trips):?>
      <div style="margin-left:20px; padding-bottom:20px;">Find exciting trips by seeing what others are up to.</div>
    <? else:?>
      <? foreach ($user->following_trips as $following_trip):?>
        <div class="home-friends-trip" style="margin:10px; border-bottom:1px solid #BABABA;">
          <div>
            <a href="<?=site_url('trips/'.$following_trip->id)?>"><?=$following_trip->name?></a>
          </div>
          <div>
            <? foreach ($following_trip->places as $place):?>
              <?=$place->name?>
              <? if ($place->startdate):?>
                <?=date('n/d/y', $place->startdate)?>
              <? else:?>
                no date set yet
              <? endif;?>                                              
            <? endforeach;?>
          </div>
          <? foreach ($following_trip->goers as $trip_goer):?>                       	                       
            <a href="<?=site_url('profile/'.$trip_goer->id)?>">
              <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$trip_goer->name?>"/>
            </a>
          <? endforeach;?>
        </div>
      <? endforeach;?>
    <? endif;?>
  </div><!-- FRIENDS TRIPS ENDS -->
</div><!-- TRAIL TAB ENDS -->