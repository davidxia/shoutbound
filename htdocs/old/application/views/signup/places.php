<div id="places-tab" class="main-tab-content">
  
  <? foreach ($user->onboarding_places as $place):?>
    <div class="streamitem">
      <div class="big-tab-avatar-container">
        <a href="<?=site_url('places/'.$place->id)?>">
          <img src="<?=static_sub('images/place_icon.png')?>" width="50" height="50">
        </a>
      </div>
      <div class="pinched streamitem-content-container">
        <div class="streamitem-name">
          <span class="place fakelink" href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></span><? if($place->country){echo ', '.$place->country;}?>
        </div>
      </div>
      <a class="follow" id="place-<?=$place->id?>">Follow</a>
      <div style="clear:both"></div>
    </div>
  <? endforeach;?>
  
</div>


