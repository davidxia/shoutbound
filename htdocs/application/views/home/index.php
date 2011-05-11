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
        'js/actionbar.js',
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
  var staticUrl = '<?=static_sub()?>';
</script>
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
    <div id="top-bar"><!--TOP BAR-->     
      <div id="home-add-post-container"><!--POST CONTAINER-->
       <div class="input-container">
          <form id="item-post-form">
            <fieldset>
              <span class="input-header">New post</span>
              <div contenteditable="true" id="post-input"></div>
              <div style="display:none;">
                <span class="input-header">Places</span><span class="input-instructions">(e.g., "Bangkok, Chiang Mai, Thailand")</span>
                <div contenteditable="true" id="tag-input" class="tag-input-form"></div>
                <span class="input-header">Trips</span><br>
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
              </div>
            </fieldset>
          </form>
          <a class="save-post-button">Post</a>

         </div>

      </div><!--END POST CONTAINER-->
  
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
          
            <? $first=TRUE; foreach($news_feed_items as $news_feed_item):?>
              <div id="post-<?=$news_feed_item->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
               <div class="streamitem-avatar-container">
                  <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>">
                    <img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" height="25" width="25"/>
                  </a>
                </div>                   
                
                <div class="streamitem-content-container">
                  <div class="streamitem-name">
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>"><?=$news_feed_item->user->name?></a>
                  </div> 
                  <div class="streamitem-content"><?=$news_feed_item->content?></div>
                  
                  <!--ACTIONBAR START-->
                  <div class="actionbar">
                    <div id="repost-post" class="bar-item">
                      <a class="add-to-trip" href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <div class="bar-item">
                      <a class="show-comments" href="#"><? $num_comments=count($news_feed_item->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                    
                    <div class="bar-item">
                      <a class="show-trips" href="#"><? $num_trips=count($news_feed_item->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>
                    </div>
                    <span class="bullet">&#149</span>                        
                    <div class="bar-item">
                      <abbr class="timeago subtext" title="<?=$news_feed_item->created?>"><?=$news_feed_item->created?></abbr>
                    </div>                        
                  </div><!--ACTIONBAR END-->
                  
                  <!--COMMENTS START-->
                  <div class="comments-container" style="display:none;">
                    <? foreach ($news_feed_item->replies as $comment):?>
                    <div class="comment">
                      <div class="streamitem-avatar-container">
                        <a href="<?=site_url('profile/'.$comment->user_id)?>">
                          <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="25" width="25"/>
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
                  
                  <!-- ADD TO TRIP -->
                  <div class="add-to-trip-cont" style="display:none;">
                    <select multiple="multiple" size=5>
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
                    <a class="post-to-trip" href="#">Post</a>
                  </div>
                  <!-- ADD TO TRIP END -->

                </div>
              </div>
            <? endforeach;?>
            
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