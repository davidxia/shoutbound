<div id="post-<?=$post->id?>" class="first-item streamitem">
  <div class="streamitem-avatar-container">
    <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>">
      <img src="<?=static_sub('profile_pics/'.$user->profile_pic)?>" height="25" width="25">
    </a>
  </div>                   
                
  <div class="streamitem-content-container">
    <div class="streamitem-name">
      <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>"><?=$user->name?></a>
    </div> 
    <div class="streamitem-content"><?=$post->content?></div>
                  
    <!--ACTIONBAR START-->
    <div class="actionbar">
      <a href="#" class="bar-item">Recommend</a>
      <span class="bullet">&#149;</span>
      <a class="bar-item show-comments" href="#">0 comments</a>
      <span class="bullet">&#149;</span>
      <abbr class="timeago subtext" title="<?=time()-72?>"><?=time()-72?></abbr>
    </div><!--ACTIONBAR END-->
                  
    <!--COMMENTS START-->
    <div class="comments-container" style="display:none;">
      <div class="comment-input-container">
        <textarea class="comment-input-area"></textarea>
        <a class="add-comment-button" href="#">Add comment</a>
      </div>  
    </div><!--END COMMENT CONTAINER-->

    <!--TRIP LISTING CONTAINER START-->
    <div class="trip-listing-container" style="display:none;">
      <? foreach($trip_ids as $trip_id):?>
      <div class="trip-listing">
        <div class="trip-listing-name">
          <a href="<?=site_url('trips/'.$trip_id)?>">TRIP NAME HERE</a>
        </div>
        <div class="trip-listing-destination-container">
          <span class="trip-listing-destination">
            <a href="http://dev.shoutbound.com/david/places/24548840">Iceland</a>
          </span>
        </div>
      </div>
      <? endforeach;?>
    </div><!--TRIP LISTING CONTAINER END-->
  </div>
</div>