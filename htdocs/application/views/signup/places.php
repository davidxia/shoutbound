<div id="places-tab" class="main-tab-content">
  
  <? foreach ($user->onboarding_places as $place):?>
  <div class="streamitem">
    <a class="follow" id="place-<?=$place->id?>">Follow</a>
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('places/'.$place->id)?>">
        <img src="<?=static_sub('images/place_icon.png')?>" width="25" height="25">
      </a>
    </div>
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a><? if($place->country){echo ', '.$place->country;}?>
      </div>
      <div class="streamitem-bio">
      </div>
    </div>
  </div>
  <? endforeach;?>
</div>


