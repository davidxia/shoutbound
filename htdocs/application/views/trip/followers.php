            <? foreach ($trip->followers as $trip_follower):?>
            	<div class="trip_follower" uid="<?=$trip_follower->id?>">
                <a href="<?=site_url('profile/'.$trip_follower->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_follower->profile_pic)?>" class="avatar" alt="<?=$trip_follower->name?>" height="38" width="38"/>
                </a>
              </div>
            <? endforeach;?>
            <? if ( ! $trip->followers):?>
              No followers...yet
            <? endif;?>
            
            </div>