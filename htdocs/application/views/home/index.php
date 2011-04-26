<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=> array(
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
        'css/home.css',
    ),
    'js_paths'=> array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/user/home.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/multiselect.min.js',
        'js/jquery/timeago.js',
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

<div id="header-content-wrapper">
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

      <div id="top-bar"><!--TOP BAR-->
       
        <div id="home-add-postitem-container"><!--POSTITEM CONTAINER-->
            <form id="item-post-form">
              <fieldset>
                <div contenteditable="true" id="item-input" style="min-height:100px; border:1px solid #333; color:#333;"></div>
                <select id="trip-selection" name="trip-selection" multiple="multiple" size=5>
                  <? foreach ($user->rsvp_yes_trips as $trip):?>
                  <option value="<?=$trip->id?>"><?=$trip->name?>
                  <? endforeach;?>
                  <? foreach ($user->rsvp_awaiting_trips as $trip):?>
                  <option value="<?=$trip->id?>"><?=$trip->name?>
                  <? endforeach;?>
                  <? foreach ($user->following_trips as $trip):?>
                  <option value="<?=$trip->id?>"><?=$trip->name?>
                  <? endforeach;?>
                </select>
                <a id="post-item" href="#">Post</a>
              </fieldset>
            </form>
        </div><!--END POSTITEM CONTAINER--> 
    
      </div><!--TOP BAR END-->

      <div id="follow-and-stats-container"><!--STATS-->
              
          <div id="stats-container">
            <ul class="stats-list">
              <li><a href="#trail" class="trip-count"><?=$user->num_rsvp_yes_trips?><span class="stat-label">Trips</span></a></li>
              <li class="border-left"><a href="#posts" class="post-count"><?=$user->num_posts?><span class="stat-label">Posts</span></a></li>
              <li class="border-left"><a href="#following" class="following-count"><?=$user->num_following+$user->num_following_trips?><span class="stat-label">Following</span></a></li>
              <li class="border-left"><a href="#followers" class="followers-count"><?=$user->num_followers?><span class="stat-label">Followers</span></a></li>
            </ul>        
          </div>
          
        </div><!--STATS END-->


    <!-- LEFT COLUMN -->
    <div id="home-col-left">    
      
      <!--HOME LEFT CONTENT CONTAINER-->      
      <div id="home-main-content-container">
              
        <ul id="main-tabs">
          <li><a href="#feed">Feed</a></li>
          <li><a href="#trail">Trail</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="feed-tab" class="main-tab-content main-tab-default">
          <? if ( ! $news_feed_items):?>
            You haven't had any activity yet. Get started by <a href="<?=site_url('trips/create')?>">creating a trip</a>, <a href="#">adding suggestions above</a>, <a href="#">following others</a>, <a href="#">following other trips</a>, or <a href="#">following a place</a>.
          <? else:?>
            <ul>
              <? foreach($news_feed_items as $news_feed_item):?>
                <li id="wall-item-<?=$news_feed_item->id?>" style="margin-bottom:10px; padding-bottom:10px; border-bottom: 1px solid #BABABA;">
                  <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>" style="margin-right:10px; float:left;">
                    <img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" class="tooltip" height="50" width="50" alt="<?=$news_feed_item->user->name?>"/>
                  </a>
                  <div style="display:table-cell; line-height:18px;">
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>"><?=$news_feed_item->user->name?></a> posted on 
                    <? foreach($news_feed_item->trips as $trip):?>
                      <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                    <? endforeach;?>
                    <br/>
                    <span><?=$news_feed_item->content?></span>
                    <br/>
                    <abbr class="timeago" title="<?=$news_feed_item->created?>" style="font-size:10px;"><?=$news_feed_item->created?></abbr>
                  </div>
                </li>
              <? endforeach;?>
            </ul>
          <? endif;?>
          </div>
        </div><!--TAB CONTAINER END-->
                    
      </div><!--HOME LEFT CONTENT CONTAINER END-->     

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="home-col-right">      
      
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas" style="height:330px;"></div>
      </div>
    </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
</div><!-- HEADER CONTENT WRAPPER ENDS-->



  <? $this->load->view('footer')?>
</body>
</html>