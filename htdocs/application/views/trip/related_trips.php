<div id="related_trips-tab" class="main-tab-content">

  <? $prefix='first-item'; foreach ($trip->related_trips as $trip):?>
  	<div id="trip-<?=$trip->id?>" class="<?=$prefix?> streamitem"><? $prefix=''?>

      <? if (isset($trip->is_following) AND $trip->is_following):?>
        <a href="#" class="unfollow">Unfollow</a>
      <? elseif (!isset($user->id) OR !$trip->is_following):?>
        <a href="#" class="follow">Follow</a>
      <? endif;?> 
  	
      <div class="streamitem-avatar-container">
        <a href="<?=site_url('trips/'.$trip->id)?>"><img src="<?=static_sub('trip_thumbnails/'.$trip->thumbnail)?>" height="25" width="25"/></a>
      </div>         
            
      <div class="narrow streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
        </div>
    </div>
  <? endforeach;?>
  
  <? if ( ! $trip->related_trips):?>
    we display trips related by tags, proximity, related people, etc
  <? endif;?>
</div>
