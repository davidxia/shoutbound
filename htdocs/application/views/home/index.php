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
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

      <div id="top-bar"><!--TOP BAR-->
        
        <!--<div id="new-postitem-button">New post</div>
        <div id="new-trip-button">New trip</div>        
       
        <div id="home-add-postitem-container"><!--POSTITEM CONTAINER-->
            <!--<form id="item-post-form">
              <fieldset>
                <div contenteditable="true" id="item-input"></div>
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
              <li class="border-left"><a href="<?=site_url('profile#posts')?>" class="post-count"><?=$user->num_posts?><span class="stat-label">Posts</span></a></li>
              <li class="border-left"><a href="<?=site_url('profile#following')?>" class="following-count"><?=$user->num_following+$user->num_following_trips?><span class="stat-label">Following</span></a></li>
              <li class="border-left"><a href="<?=site_url('profile#followers')?>" class="followers-count"><?=$user->num_followers?><span class="stat-label">Followers</span></a></li>
            </ul>        
          </div>
          
        </div><!--STATS END-->


    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--LEFT CONTENT CONTAINER-->      
      <div id="left-content-container">
              
        <ul id="main-tabs">
          <li><a href="#feed">Feed</a></li>
          <li><a href="#trail">Trail</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="feed-tab" class="main-tab-content main-tab-default">
          <? if ( ! $news_feed_items):?>
            You haven't had any activity yet. Get started by <a href="<?=site_url('trips/create')?>">creating trips</a>, <a href="#">adding posts</a>, and <a href="#">following other people</a>, <a href="#"> trips</a>, and <a href="#"> places</a>.
          <? else:?>
          
            <ul>
              <? $first=TRUE; foreach($news_feed_items as $news_feed_item):?>
                <li id="postitem-<?=$news_feed_item->id?>" class="<? if($first):?><? echo 'first-postitem'; $first=FALSE;?><? endif;?> postitem">
                  <div class="postitem-avatar-container">
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>">
                      <img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" class="tooltip" height="36" width="36" alt="<?=$news_feed_item->user->name?>"/>
                    </a>
                  </div>                  
                  
                  <div class="postitem-content-container">
                    <div class="postitem-author-name">
                      <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>"><?=$news_feed_item->user->name?></a>
                    </div> 
                    <div class="postitem-content"><?=$news_feed_item->content?></div>
                    <span><abbr class="timeago subtext" title="<?=$news_feed_item->created?>"><?=$news_feed_item->created?></abbr></span>
                    
                    <? foreach($news_feed_item->trips as $trip):?>
                      <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                    <? endforeach;?>

                  </div>
                  
                </li>
              <? endforeach;?>
            </ul>
          <? endif;?>
          </div>
        </div><!--TAB CONTAINER END-->
                    
      </div><!--LEFT CONTENT CONTAINER END-->     

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="col-right">      
      
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas" style="height:330px;"></div>
      </div>
    </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
</body>
</html>