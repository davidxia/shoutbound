<div id="followers-tab" class="main-tab-content">
  <? foreach ($trip->followers as $follower):?>
  	<div class="trip-follower" uid="<?=$follower->id?>">
      <a href="<?=site_url('profile/'.$follower->id)?>">
        <img src="<?=static_sub('profile_pics/'.$follower->profile_pic)?>" class="tooltip" alt="<?=$follower->name?>" height="38" width="38"/></a>
      <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
    </div>
  <? endforeach;?>
  
  <? if ( ! $trip->followers):?>
    No followers...yet
  <? endif;?>
</div>