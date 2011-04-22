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
  var baseUrl = '<?=site_url()?>';
</script>

<style type="text/css">
.tooltip_container{
  position:absolute;
  background:url(/david/images/dark_arrow.png) 50% 0 no-repeat;
  padding:7px 0 0 0;
  z-index:500;
}
.tooltip_interior{
  font-size:12px;
  background:url(/david/images/tooltip.png);
  color:white;
  padding:3px 6px;
}
.tooltip_interior div{
  margin-top:2px;
  font-size:.97em;
}
</style>

</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

		<!-- TRIPS COLUMN -->
		<div style="float:right; width:350px;">
		  <!-- USERS TRIPS -->
      <div id="user-trips" style="background-color:white; -moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gary; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8; margin-bottom:20px;">
				<div style="background-color:#C6D4E1; line-height:30px; height:30px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
  				<span style="font-size:16px; padding-left:10px; font-weight:bold; color:black;">Your trips</span>
				</div>
				<? if (empty($trips)):?>
          <div style="padding:0px 0px 20px 20px;">You don't have any trips yet.  Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
        <? else:?>
          <? foreach ($trips as $trip):?>
            <div class="home-users-trip" style="margin:10px; border-bottom:1px solid #BABABA;">
              <div>
                <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
              </div>
              <div>
                <? foreach ($trip->places as $place):?>
                  <?=$place->name?>
                  <? if ($place->startdate):?>
                    <?=date('n/d/y', $place->startdate)?>
                  <? else:?>
                    no date set yet
                  <? endif;?>               
                <? endforeach;?>
              </div>
              <? foreach ($trip->goers as $trip_goer):?>                       	                       
                <a href="<?=site_url('profile/'.$trip_goer->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_goer->profile_pic)?>" class="avatar" height="32" width="32" alt="<?=$trip_goer->name?>"/>
                </a>
              <? endforeach;?>
            </div>
          <? endforeach;?>
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
          <? foreach ($advising_trips as $advising_trip):?>
            <div class="home-friends-trip" style="margin:10px; border-bottom:1px solid #BABABA;">
              <div>
                <a href="<?=site_url('trips/'.$advising_trip->id)?>"><?=$advising_trip->name?></a>
              </div>
              <div>
                <? foreach ($advising_trip->places as $place):?>
                  <?=$place->name?>
                  <? if ($place->startdate):?>
                    <?=date('n/d/y', $place->startdate)?>
                  <? else:?>
                    no date set yet
                  <? endif;?>                                              
                <? endforeach;?>
              </div>
              <? foreach ($advising_trip->users as $trip_user):?>                       	                       
                <a href="<?=site_url('profile/'.$trip_user->id)?>">
                  <img src="<?=static_sub('profile_pics/'.$trip_user->profile_pic)?>" height="32" width="32"/>
                </a>
              <? endforeach;?>
            </div>
          <? endforeach;?>
        <? endif;?>
      </div><!-- FRIENDS TRIPS ENDS -->
		
		</div><!-- TRIPS COLUMN ENDS -->

    
    <!-- LEFT COLUMN -->
    <div style="width:520px;">
      <div>
        <form id="item-post-form">
          <fieldset>
            <textarea id="item-input" style="width:510px; height:100px;"></textarea>
            <select name="trip-selection" multiple size=5>
              <option value="mushrooms">mushrooms
              <option value="greenpeppers">green peppers
              <option value="onions">onions
              <option value="tomatoes">tomatoes
              <option value="olives">olives
            </select>
            <input type="submit" value="submit"/>
          </fieldset>
        </form>
      </div>
      
      <!-- NEWS FEED -->
  		<div id="news-feed" style="-moz-box-shadow: 0px 0px 2px gray; -webkit-box-shadow: 0px 0px 2px gray; box-shadow: 0px 0px 2px gray; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:1px solid #C8C8C8;">
  			<div style="background-color:#C6D4E1; line-height:30px; height:30px; margin-bottom:15px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; border-radius: 5px 5px 0px 0px; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #C8C8C8;">
  				<span style="font-size:16px; padding-left:10px; font-weight:bold;">Recent activity</span>
  			</div>
        <? if ( ! $news_feed_items):?>
          <div style="padding:0px 0px 20px 20px;">You haven't had any activity yet.  Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>.</div>
        <? else:?>
          <ul style="margin: 0px 20px 0px 20px;">
            <? foreach($news_feed_items as $news_feed_item):?>
              <li id="wall-item-<?=$news_feed_item->id?>" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="margin-right:10px; float:left;"><img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" height="50" width="50"/></a>
                <div style="display:table-cell; line-height:18px;">
                  <?=$news_feed_item->user->name?> wrote <span style="font-weight:bold;"><?=$news_feed_item->content?></span>
                  <br/>
                  on <a href="<?=site_url('trips/'.($news_feed_item->trip_id))?>"><?=$news_feed_item->trip->name?></a>
                  <br/>
                  <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                </div>
              </li>
            <? endforeach;?>
          </ul>
        <? endif;?>
  		</div><!-- NEWS FEED ENDS -->
    </div><!-- LEFT COLUMN ENDS -->

  </div><!-- MAIN ENDS -->
  </div><!-- WRAPPER ENDS -->

  <? $this->load->view('footer')?>

</body>

<script type="text/javascript">
  $('abbr.timeago').timeago();
  
  $(function() {
    var delay;
    $('.avatar').mouseover(function() {
      var img = $(this);
      
      delay = setTimeout(function() {
        var title = img.attr('alt');

        // element location and dimensions
        var element_offset = img.offset(),
            element_top = element_offset.top,
            element_left = element_offset.left,
            element_height = img.height(),
            element_width = img.width();
        
        var tooltip = $('<div class="tooltip_container"><div class="tooltip_interior">'+title+'</div></div>');
        $('body').append(tooltip);
    
        // tooltip dimensions
        var tooltip_height  = tooltip.height();
        var tooltip_width = tooltip.width();
        tooltip.css({ top: (element_top + element_height + 3) + 'px' });
        tooltip.css({ left: (element_left - (tooltip_width / 2) + (element_width / 2)) + 'px' });
      }, 200);
    }).mouseout(function() {
      $('.tooltip_container').remove();
      clearTimeout(delay);
    });
  });

</script>
</html>