<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=> array(
    ),
    'js_paths'=> array(
        'js/jquery/timeago.js'
    )
);
$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url(''); ?>";
  var staticUrl = "<?=static_url(''); ?>";
</script>


</head> 
<body style="background-color:#1B272C; min-width:960px;">

  <? $this->load->view('header')?>

  <div class="wrapper" style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">
    <!-- MAIN -->
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
      
      <div style="border: 1px solid #ced7de; background-color:#FFFFFF; border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px; min-height:300px;">
        <? if ($num_friend_requests):?>
          You have <a href="<?=site_url('friends/edit')?>"><?=$num_friend_requests?> friend requests</a>
        <? endif;?>
      
        <!-- NEWS FEED -->
  			<div id="news-feed" style="float:left; width:554px; padding-left:20px;">
  				<div style="margin:10px 0px 10px;">
    				<span style="font-size:24px;">News feed</span>
  				</div>
          <? if ( ! $news_feed_items):?>
            <span>There are no news items yet...</span>
          <? else:?>
            <ul>
              <? foreach($news_feed_items as $news_feed_item):?>
                <li id="wall-item-<?=$news_feed_item->id?>" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                <? if ($news_feed_item->is_location):?>
                  <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="margin-right:10px; float:left;"><img src="http://graph.facebook.com/<?=$news_feed_item->user_fid?>/picture?type=square" /></a>
                  <div style="display:table-cell; line-height:18px;">
                    <?=$news_feed_item->user_name?> suggested <span style="font-weight:bold;"><?=$news_feed_item->name?></span>
                    <br/>
                    for <a href="<?=site_url('trips/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip_name?></a>
                    <br/>
                    <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                  </div>
                <? else:?>
                  <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="margin-right:10px; float:left;"><img src="http://graph.facebook.com/<?=$news_feed_item->user_fid?>/picture?type=square" /></a>
                  <div style="display:table-cell; line-height:18px;">
                    <?=$news_feed_item->user_name?> wrote <span style="font-weight:bold;"><?=$news_feed_item->text?></span>
                    <br/>
                    on <a href="<?=site_url('trips/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip_name?></a>
                    <br/>
                    <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                  </div>
                <? endif;?>
                </li>
              <? endforeach;?>
            </ul>
          <? endif;?>
  			</div><!-- NEWS FEED ENDS -->
  			
  			<!-- TRIPS COLUMN -->
  			<div style="float:left; width:364px; padding-left:20px;">
  			  <!-- USERS TRIPS -->
          <div id="user-trips">
    				<div style="margin:10px 0px 10px;">
      				<span style="font-size:24px;">Your trips</span>
    				</div>
    				<? if (empty($trips)):?>
              You don't have any trips yet...
            <? else:?>
              <ul>
                <? foreach ($trips as $trip):?>
                  <li class="user-trip" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                    <div class="user-trip-name">
                      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                    </div>
                    <? foreach ($trip->destinations as $destination):?>
                      <ul class="trip-content" style="margin-top:10px;">
                        <li class="trip-place" style="float:left; width:30%; font-size:12px;">
                          <?=$destination->address?>
                        </li>
                        <li class="trip-startdate" style="float:left; width:30%; font-size:12px;">
                          <? if ($destination->startdate):?>
                            <?=date('n/d/y', $destination->startdate)?>
                          <? else:?>
                            no date set yet
                          <? endif;?>
                        </li>
                        <li class="trip-avatar-container">
                        <? foreach ($trip->users as $trip_user):?>
                          <a href="<?=site_url('profile/'.$trip_user->id)?>"><img style="height:32px; width:32px;" src="http://graph.facebook.com/<?=$trip_user->fid?>/picture?type=square" />
                          </a>
                        <? endforeach;?>
                        </li>
                      </ul>
                    <? endforeach;?>
                  </li>
                <? endforeach;?>
              </ul>
            <? endif; ?>
          </div><!-- USERS TRIPS ENDS -->
          
          <!-- FRIENDS TRIPS -->
          <div id="home-friends-trips">
    				<div style="margin:10px 0px 10px;">
      				<span style="font-size:24px;">Your friends' trips</span>
    				</div>
    				<? if (empty($advising_trips)):?>
              Tell your friends to share some trips with you.
            <? else:?>
              <ul>
                <? foreach ($advising_trips as $advising_trip):?>
                  <li class="home-trip">
                    <div class="home-trip-name">
                      <a href="<?=site_url('trips/'.$advising_trip->id)?>"><?=$advising_trip->name?></a>
                    </div>
                    <ul class="trip-content" style="margin-top:10px;">
                      <li class="trip-place" style="float:left; width:30%; font-size:12px;">Chatham, MA</li>
                      <li class="trip-startdate" style="float:left; width:30%; font-size:12px;">February 23-27, 2011</li>
                      <li class="trip-avatar-container">
                        <? foreach ($advising_trip->users as $trip_user):?>
                          <img style="height:32px; width:32px;" src="http://graph.facebook.com/<?=$trip_user->fid?>/picture?type=square" />
                        <? endforeach;?>
                      </li>
                    </ul>
                  </li>
                <? endforeach;?>
              </ul>
            <? endif;?>
          </div><!-- FRIENDS TRIPS ENDS -->
  			
  			</div><!-- TRIPS COLUMN ENDS -->
	      <div style="clear:both;"></div>
      </div>
        
    </div><!-- MAIN ENDS -->
  </div><!-- WRAPPER ENDS -->

  <?=$this->load->view('footer')?>

</body>

<script type="text/javascript">
  $('abbr.timeago').timeago();
</script>

</html>