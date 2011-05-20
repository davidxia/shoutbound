<div id="places-tab" class="main-tab-content">
  <? if ($user->following_places):?>
    We've followed the places you said you wanted to go.
  <? endif;?>
  
  <? foreach ($user->following_places as $following_place):?>
  <div class="streamitem">
    <a class="unfollow" id="place-<?=$following_place->id?>">Unfollow</a>
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('places/'.$following_place->id)?>">
        <img src="<?=static_sub('images/place_icon.png')?>" width="25" height="25">
      </a>
    </div>
    <div class="narrow streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('places/'.$following_place->id)?>"><?=$following_place->name?></a>
      </div>
      <div class="streamitem-bio">
      </div>
    </div>
  </div>
  <? endforeach;?>
</div>