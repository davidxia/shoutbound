<div id="related_places-tab" class="main-tab-content">
  <? if ( ! $place->related_places):?>
    There are no related places.
  <? endif;?>
  
  <? $prefix='first-item'; foreach ($place->related_places as $place):?>
  	<div class="<?=$prefix?> streamitem"><? $prefix=''?>

      <? if (isset($place->is_following) AND $place->is_following):?>
      <a href="#" class="unfollow" id="place-<?=$place->id?>">Unfollow</a>
      <? elseif (!isset($user->id) OR !$place->is_following):?>
      <a href="#" class="follow" id="place-<?=$place->id?>">Follow</a>
      <? endif;?> 
  	
      <div class="streamitem-avatar-container">
        <a href="<?=site_url('places/'.$place->id)?>"><img src="<?=static_sub('images/place_icon.png')?>" height="25" width="25"/></a>
      </div>         
            
      <div class="narrow streamitem-content-container">
        <div class="streamitem-name">
          <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a>
        </div>
      </div>
      <div style="clear:both"></div> 
    </div>
  <? endforeach;?>
</div>
