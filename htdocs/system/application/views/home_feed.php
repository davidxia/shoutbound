<? if ( ! $news_feed_items):?>
    <span class="sidebar-message">There are no news items yet...</span>
<? else:?>

<? foreach($news_feed_items as $news_feed_item):?>

    <div id="wall-item-<?=$news_feed_item->id?>" class="wall-item">
    
    <? if ($news_feed_item->is_location):?>
    
        <div class="wall-comment wall-root-comment">
    
            <div class="nn-fb-img left"><img class="square-50" src="http://graph.facebook.com/<?=$news_feed_item->user_fid?>/picture?type=square" /></div>
              <div class="wall-text left">
                  <span class="wall-comment-username"><?=$news_feed_item->user_name?></span>
                  <span class="wall-comment-text"> suggested <span id="wall-location-name-<?=$news_feed_item->id?>" class="wall-location-text"></span>
                  <br/>
                  <span class="feed-trip-reference-text">
                      for <?=$news_feed_item->name?>'s trip - <a href="<?=site_url('trip/details/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip_name?></a>
                  </span>
                  
                  </span>
                  <br/>
                  <span class="wall-timestamp">on <?=$news_feed_item->created?></span>
              </div>
            <div class="clear-both"></div>
        </div>
    
    
    <? else:?>
    
        <div class="wall-comment wall-reply-comment">
    
            <div class="nn-fb-img left"><img class="square-50" src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
              <div class="wall-text left">
                  <span class="wall-comment-username"> <?=$item['user']['name']?> </span>
                  <span class="wall-comment-text"> "<?=$item['body'];?>" </span>
                  <br/>
                  <span class="feed-trip-reference-text">
                        for <?=$item['trip']['user']['name']?>'s trip - <a href="<?=site_url('trip/details/'.($item['tripid']))?>"><?=$item['trip']['name'];?></a>
                  </span>
                  
                  <br/>
                  <span class="wall-timestamp">on <?=date("m/d/y",strtotime($item['created']))?></span>
              </div>
    
    
    
            <div class="clear-both"></div>
        </div>
        
    <? endif;?>
    
    </div>
    
<? endforeach;?>
<? endif;?>