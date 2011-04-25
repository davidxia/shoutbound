<!-- NEWS FEED -->
  		<div id="news-feed" style="-moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gray; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8;">
  			<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
  				<span style="font-size:16px; padding-left:10px; font-weight:bold;">Recent activity</span>
  			</div>
        <? if ( ! $news_feed_items):?>
          <div style="padding:0px 0px 20px 20px;">You haven't had any activity yet. Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>, <a href="#">adding suggestions above</a>, <a href="#">following others</a>, <a href="#">following other trips</a>, or <a href="#">following a place</a>.</div>
        <? else:?>
          <ul style="margin: 0px 20px 0px 20px;">
            <? foreach($news_feed_items as $news_feed_item):?>
              <li id="wall-item-<?=$news_feed_item->id?>" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="margin-right:10px; float:left;">
                  <img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" class="tooltip" height="50" width="50" alt="<?=$news_feed_item->user->name?>"/>
                </a>
                <div style="display:table-cell; line-height:18px;">
                  <?=$news_feed_item->user->name?> wrote <span style="font-weight:bold;"><?=$news_feed_item->content?></span>
                  <br/>
                  on 
                  <? foreach($news_feed_item->trips as $trip):?>
                    <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                  <? endforeach;?>
                  <br/>
                  <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                </div>
              </li>
            <? endforeach;?>
          </ul>
        <? endif;?>
  		</div><!-- NEWS FEED ENDS -->