<div id="trips-tab" class="main-tab-content">

  <!-- RSVP AWAITING TRIPS -->
    <? foreach ($user->rsvp_awaiting_trips as $rsvp_awaiting_trip):?>
      <div class="streamitem">
        <div class="big-tab-avatar-container">
          <a href="<?=site_url('trips/'.$rsvp_awaiting_trip->id)?>"><img src="<?=static_sub('images/trip_icon.png')?>" width="50" height="50"/></a>
        </div>
      
        <div class="pinched streamitem-content-container">     
          <span class="streamitem-name">
            <a href="<?=site_url('trips/'.$rsvp_awaiting_trip->id)?>"><?=$rsvp_awaiting_trip->name?></a>
          </span>
          <span class="RSVP-required">(Awaiting response)</span>
          <div class="streamitem-bio">
            <?=$rsvp_awaiting_trip->description?> 
          </div>                
          <div class="destinationbar">
          Going to:
          <? $prefix = ''; foreach ($rsvp_awaiting_trip->places as $place):?>
              <?=$prefix?>
              <a href="<?=site_url('places/'.$place->id)?>" class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>">
                <?=$place->name?>
              </a>
<!--
              <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
              <? $prefix = ' <span class="bullet">&#149</span> '?>
-->
          <? endforeach;?>
          </div>
        
          <div class="goersbar">
            <? foreach ($rsvp_awaiting_trip->goers as $trip_goer):?> 
              <div class="bar-item">                      	                       
                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$trip_goer->name?>"/>
                </a>
              </div>
            <? endforeach;?>
          </div>
          <div style="clear:both"></div>          
        </div>
      <? endforeach;?>
    <!-- RSVP AWAITING TRIPS ENDS -->

  <!-- RSVP YES TRIPS -->
  <? if (empty($user->rsvp_yes_trips)):?>
    <div class="nothingyet-copy">Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a> for your next travel adventure!</div>
    
  <? else:?>
    <? $first=TRUE; foreach ($user->rsvp_yes_trips as $rsvp_yes_trip):?>
      <div "tripitem-<?=$rsvp_yes_trip->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
        <div class="big-tab-avatar-container">
          <a href="<?=site_url('trips/'.$rsvp_yes_trip->id)?>"><img src="<?=static_sub('images/trip_icon.png')?>" width="50" height="50"/></a>
        </div>      
        <div class="pinched streamitem-content-container">     
          
          <div class="streamitem-name">
            <a href="<?=site_url('trips/'.$rsvp_yes_trip->id)?>"><?=$rsvp_yes_trip->name?></a>
          </div>
                 
          <div class="destinationbar">
            Going to:
            <? $prefix = ''; foreach ($rsvp_yes_trip->places as $place):?>
                <?=$prefix?>
                <a href="<?=site_url('places/'.$place->id)?>" class="place bar-item" lat="<?=$place->lat?>" lng="<?=$place->lng?>">
                  <?=$place->name?>
                </a>
    <!--
                <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
                <? $prefix = ' <span class="bullet" style="display:none">&#149</span> '?>
    -->
            <? endforeach;?>
            </div>
            <div class="streamitem-bio">
              <?=$rsvp_yes_trip->description?>        
            </div>
  
          <div class="goersbar">
            <? foreach ($rsvp_yes_trip->goers as $goer):?>
              <div class="bar-item">                       	                       
                <a href="<?=site_url('profile/'.$goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$goer->name?>"/>
                </a>
              </div>
            <? endforeach;?>
          </div>
        </div>               
        <div style="clear:both"></div>        
      </div>      
    <? endforeach;?>
  <? endif; ?>
  <!-- RSVP YES TRIPS ENDS -->
  
  <!--RSVP NO TRIPS-->
    <? foreach ($user->rsvp_no_trips as $rsvp_no_trip):?>
      <div class="streamitem">
        <div class="big-tab-avatar-container">
          <a href="<?=site_url('trips/'.$rsvp_no_trip->id)?>"><img src="<?=static_sub('images/trip_icon.png')?>" width="50" height="50"/></a>
        </div>
      
        <div class="pinched streamitem-content-container">     
          <span class="streamitem-name">
            <a href="<?=site_url('trips/'.$rsvp_no_trip->id)?>"><?=$rsvp_no_trip->name?></a>
          </span>
          <span class="RSVP-no">(You said no)</span>
          <div class="streamitem-bio">
            <?=$rsvp_no_trip->description?> 
          </div>                
          <div class="destinationbar">
          Going to:
          <? $prefix = ''; foreach ($rsvp_no_trip->places as $place):?>
            <?=$prefix?>
            <a href="<?=site_url('places/'.$place->id)?>" class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>">
              <?=$place->name?>
            </a>
<!--
            <span class="subtext"><? if($place->dates['startdate']){echo date('F j, Y',$place->dates['startdate']);} if($place->dates['startdate'] AND $place->dates['enddate']){echo ' - ';} if ($place->dates['enddate']){echo date('F j, Y', $place->dates['enddate']);}?></span>
            <? $prefix = ' <span class="bullet">&#149</span> '?>
-->
            <? endforeach;?>
          </div>      
          <div class="goersbar">
            <? foreach ($rsvp_no_trip->goers as $trip_goer):?> 
              <div class="bar-item">                      	                       
                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="tooltip" height="25" width="25" alt="<?=$trip_goer->name?>"/>
                </a>
              </div>
            <? endforeach;?>
          </div>
        </div>
        <div style="clear:both"></div>
      </div>                    
      <? endforeach;?>
  <!--RSVP NO TRIPS END-->
  
  
</div>