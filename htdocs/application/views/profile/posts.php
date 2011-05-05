<div id="posts-tab" class="main-tab-content">
  <? if ( ! $profile->posts):?>
  <div style="padding:10px 20px">
    <?=$profile->name?> hasn't posted anything yet.
  </div>
  <? endif;?>
    
  <? $first=TRUE; foreach ($profile->posts as $post):?>
  <div id="postitem-<?=$post->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('profile/'.$profile->id)?>">
        <img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" height="25" width="25"/>
      </a>
    </div>
      
    <div class="streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('profile/'.$profile->id)?>"><?=$profile->name?></a>
      </div>
      <div class="streamitem-content">
        <?=$post->content?>
      </div>        
      <div class="actionbar">
        <div id="repost-postitem" class="actionbar-item">
          <a href="#">Add to trip</a>                      
        </div>
        <span class="bullet">&#149</span>
        <div class="actionbar-item">
          <!--<a class="show-comments" href="#"><? $num_comments=count($news_feed_item->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>-->
        </div>
        <span class="bullet">&#149</span>                    
        <div class="actionbar-item">
          <!--<a class="show-trips" href="#"><? $num_trips=count($news_feed_item->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>-->
        </div>
        <span class="bullet">&#149</span>                        
        <div class="actionbar-item">
          <abbr class="timeago subtext" title="#"</abbr>
        </div>                        
      </div>
      
      <!--COMMENTS START-->
      <div class="comments-container" >
        <? foreach ($post->replies as $comment):?>
        <div class="comment">
          <div class="streamitem-avatar-container">
            <a href="<?=site_url('profile/'.$comment->user_id)?>">
              <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="28" width="28"/>
            </a>
          </div>                      
          <div class="streamitem-content-container">
            <div class="streamitem-name">
              <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->user->name?></a>
            </div> 
            <div class="comment-content"><?=$comment->content?></div>
            <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr></div>                      
            </div>
          </div>
        </div>
        <? endforeach;?>
        <div class="comment-input-container">
          <textarea class="comment-input-area"/></textarea>
          <a class="add-comment-button" href="#">Add comment</a>
        </div>  
      </div><!--END COMMENT CONTAINER-->
  
      <!--TRIP LISTING CONTAINER START-->
      <div class="trip-listing-container" >
      <? foreach ($post->trips as $trip):?>
        <div class="trip-listing">
          <div class="trip-listing-name"><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></div>
          <div class="trip-listing-destination-container">
          <? $prefix=''; foreach ($trip->places as $place):?>
            <?=$prefix?>
            <span class="trip-listing-destination"><a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a></span>
            <span class="subtext"><? if($place->startdate){echo date('F j, Y',$place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
            <? $prefix = '<span class="bullet">&#149</span>'?>
          <? endforeach;?>
          </div>
        </div>
      <? endforeach;?>
      </div><!--TRIP LISTING CONTAINER END-->
    </div><!--POSTITEM CONTENT CONTAINER END-->
  </div><!--END POSTITEM-->
  <? endforeach;?>
  
</div><!--END TAB-->