    <?
    if(!$news_feed_data){
        
        echo('<span class="sidebar-message">There are no news items yet...</span>');
        
    }
    
    
    foreach($news_feed_data as $item) { 
    ?>

    <div id="wall-item-<?=$item[itemid]?>" class="wall-item">

    <?php if($item['islocation']){ ?>

        <div class="wall-comment wall-root-comment">

            <div class="nn-fb-img left"><img class="square-50" src="http://graph.facebook.com/<?=$item['user']['fid']?>/picture?type=square" /></div>
              <div class="wall-text left">
                  <span class="wall-comment-username"> <?=$item['user']['name']?> </span>
                  <span class="wall-comment-text"> suggested <span id="wall-location-name-<?=$item['itemid'];?>" class="wall-location-text"><?=json_decode($item['yelpjson'])->name?> </span>
                  <br/>
                  <span class="feed-trip-reference-text">
                      for <?=$item['trip']['user']['name']?>'s trip - <a href="<?=site_url('trip/details/'.($item['tripid']))?>"><?=$item['trip']['name'];?></a>
                  </span>
                  
                  </span>
                  <br/>
                  <span class="wall-timestamp">on <?=date("m/d/y",strtotime($item['created']))?></span>
              </div>
            <div class="clear-both"></div>
        </div>


    <?} else {?>

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
        <?
    }

    ?></div>
        
    <? } ?>