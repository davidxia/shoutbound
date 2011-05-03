<div id="posts-tab" class="main-tab-content">
  <? if ( ! $profile->posts):?>
    <?=$profile->name?> hasn't posted anything yet.
  <? endif;?>
    
  <? foreach ($profile->posts as $post):?>
  
    <div class="postitem">
      <div class="postitem-avatar-container">
        <a href="#">
          <img src="#" height="48" width="48"/>
        </a>
      </div>
      
      <div class="postitem-content-container">
        <div class="postitem-author-name">
          <a>Authorname here</a>
        </div>
        <div class="postitem-content">
          <?=$post->content?>
        </div>        
        <div class="postitem-actionbar">
          <div id="repost-postitem" class="postitem-actionbar-item">
            <a href="#">Add to trip</a>                      
          </div>
          <span class="bullet">&#149</span>
          <div class="postitem-actionbar-item">
            <!--<a class="show-comments" href="#"><? $num_comments=count($news_feed_item->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>-->
          </div>
          <span class="bullet">&#149</span>                    
          <div class="postitem-actionbar-item">
            <!--<a class="show-trips" href="#"><? $num_trips=count($news_feed_item->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>-->
          </div>
          <span class="bullet">&#149</span>                        
          <div class="postitem-actionbar-item">
            <abbr class="timeago subtext" title="#"</abbr>
          </div>                        
        </div>
        
        <!--COMMENTS START-->
        <div class="comments-container" style="display:none;">
          <? foreach ($news_feed_item->replies as $comment):?>
          <div class="comment">
            <div class="postitem-avatar-container">
              <a href="<?=site_url('profile/'.$comment->user_id)?>">
                <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="32" width="32"/>
              </a>
            </div>                      
            <div class="comment-content-container">
              <div class="comment-author-name">
                <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->user->name?></a>
              </div> 
              <div class="comment-content"><?=$comment->content?></div>
              <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr></div>                      
            </div>
          </div> 
          <? endforeach;?>
          <div class="comment-input-container">
            <textarea class="comment-input-area"/></textarea>
            <a class="add-comment-button" href="#">Add comment</a>
          </div>  
        </div><!--END COMMENT CONTAINER-->
  
        <!--TRIP LISTING CONTAINER START-->
        <div class="trip-listing-container" style="display:none;">
        <? foreach ($news_feed_item->trips as $trip):?>
          <div class="trip-listing">
            <div class="trip-listing-name"><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></div>
            <div class="trip-listing-destination-container">
            <? $prefix=''; foreach ($trip->places as $place):?>
              <span class="trip-listing-destination"><a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a></span>
              <?=$prefix?>
              <? $prefix = '<span class="bullet">&#149</span>'?>
            <? endforeach;?>
            </div>
          </div>
        <? endforeach;?>
        </div><!--TRIP LISTING CONTAINER END-->
              
      </div><!--END POSTITEM-->
      
      <!--OLD TRIPS AND COMMENTS CODE-->
      <!--<? foreach ($post->trips as $trip):?>
      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
      <? endforeach;?>              
      <abbr class="timeago" title="<?=$post->created?>"><?=$post->created?></abbr>
    </div>-->
  <? endforeach;?>
  
</div><!--END TAB-->