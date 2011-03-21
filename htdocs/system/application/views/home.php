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
<body style="background-color:white; min-width:960px;">

<style type="text/css">
.content{
	font-size:14px;
	line-height:18px;
}
</style>

  <? $this->load->view('header')?>

  <div class="wrapper" style="background-color:#EBE7E0;">
  
    <!-- MAIN -->
    <div class="content" style="margin:auto; width:960px;padding-top:30px; padding-bottom:70px;">
      
      <div style="min-height:300px;">
        <? if ($num_friend_requests):?>
          You have <a href="<?=site_url('friends/edit')?>"><?=$num_friend_requests?> friend requests</a>
        <? endif;?>
      
        <!-- NEWS FEED -->
  			<div id="news-feed" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gray; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; width:450px; float:left; display:inline-block; margin:0px 20px 0px 60px;">
  				<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
    				<span style="font-size:16px; padding-left:10px; font-weight:bold;">Recent activity</span>
  				</div>
          <? if ( ! $news_feed_items):?>
            <div style="padding:0px 0px 20px 20px;">You haven't had any activity yet.  Get started by creating a trip!</div>
          <? else:?>
            <ul style="margin: 0px 20px 0px 20px;">
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
  			<div style="float:left; display:inline-block; width:350px; padding-left:20px;">
  			  <!-- USERS TRIPS -->
          <div id="user-trips" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gary; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; margin-bottom:20px;">
    				<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
      				<span style="font-size:16px; padding-left:10px; font-weight:bold; color:black;">Your trips</span>
    				</div>
    				<? if (empty($trips)):?>
              <div style="padding:0px 0px 20px 20px;">You don't have any trips yet.  Get started by creating a trip!</div>
            <? else:?>
              <ul style="margin: 0px 20px 0px 20px;">
                <? foreach ($trips as $trip):?>
                  <li class="user-trip" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                    <div class="user-trip-name">
                      <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                    </div>
                    <? foreach ($trip->destinations as $destination):?>
                      <ul class="trip-content" style="margin-top:5px;">
                        <li class="trip-place" style="float:left; font-size:12px;">
                          <?=$destination->address?>
                        </li>
                        <li class="trip-startdate" style="float:left; margin-left:20px; font-size:12px;">
                          <? if ($destination->startdate):?>
                            <?=date('n/d/y', $destination->startdate)?>
                          <? else:?>
                            no date set yet
                          <? endif;?>                                              
                        </li>
                        
                        <div style="clear:both"></div>
                        
                        <li class="trip-avatar-container">
                        <? foreach ($trip->users as $trip_user):?>                       	                       
                          <a href="<?=site_url('profile/'.$trip_user->id)?>"><img style="height:32px; width:32px; margin-top:5px;" src="http://graph.facebook.com/<?=$trip_user->fid?>/picture?type=square" />
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
          <div id="home-friends-trips" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gary; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8;">
    				<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
      				<span style="font-size:16px; padding-left:10px; font-weight:bold;color:black;">Your friends' trips</span>
    				</div>
    				<? if (empty($advising_trips)):?>
              <div style="margin-left:20px; padding-bottom:20px;">You haven't been invited to any <br>trips yet.</div>
            <? else:?>
              <ul style="margin-left:20px;">
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