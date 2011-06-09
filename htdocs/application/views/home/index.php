<?
$header_args = array(
    'title' => 'Shoutbound',
    'css_paths'=> array(
        'css/home.css',
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
    ),
    'js_paths'=> array(
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/jquery/jquery.ba-bbq.min.js',
        'js/jquery/nicEdit.js',
        'js/savepost.js',
        'js/actionbar.js',
        'js/common.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticUrl = '<?=static_sub()?>';
  var swLat = -50;
  var swLng = -180;
  var neLat = 50;
  var neLng = 180;
</script>
</head>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

    <div id="top-section"><!--TOP SECTION-->  

    </div><!--TOP SECTION END-->
    
    <div id="autocomplete-box" style="background:#222; position:absolute; z-index:99; padding:3px;display:none;">
      <input id="autocomplete-input" type="text" style="width:150px;border:none;border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px; padding:3px;"/>
      <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="position:absolute; right:20px; top:7px;"/>
      <a id="autocomplete-close" href="#">
        <img alt="close" src="<?=site_url('static/images/white_x.png')?>" width="10" height="9"/>
      </a>
    </div>

    <!-- LEFT COLUMN -->
    <div id="col-left">    
      
      <!--LEFT CONTENT CONTAINER-->      
      <div id="left-content-container">
              
        <ul id="main-tabs">
          <li><a href="#feed">Feed</a></li>
          <li><a href="#trips">Trips</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
             
          <div id="feed-tab" class="main-tab-content main-tab-default">

            <div id="new-post-container"><!--POST CONTAINER-->
              <div id="post-input-header">Share a travel experience</div>
              <div class="input-container">
                <form class="save-post-form">
                  <fieldset>
                    <div id="instruction-bar">Use the @ key when you refer to a place (e.g., "@Barcelona")</div>                  
                    <div contenteditable="true" id="post-input"></div>
                    <div id="add-to-trip-main">
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
                <div id="save-post-button-container">
                  <a id="save-post-button">Post</a>
                </div>
                <div style="clear:both"></div>
              </div>
            </div><!--END NEW POST CONTAINER-->
            
          <? if ( ! $user->news_feed_items):?>
            You haven't had any activity yet. Get started by <a href="<?=site_url('trips/create')?>">creating trips</a>, sharing travel experiences</a>, and <a href="#">following other people</a>, <a href="#"> trips</a>, and <a href="#"> places</a>.
          <? else:?>
          
            <? $prefix1='first-item'; foreach($user->news_feed_items as $news_feed_item):?>
              <div id="post-<?=$news_feed_item->id?>" class="<?=$prefix1?> streamitem"><? $prefix1=''?>

                <div class="streamitem-avatar-container">
                  <a href="<? if($news_feed_item->author->username){echo site_url($news_feed_item->author->username);}else{echo site_url('profile/'.$news_feed_item->user_id);}?>">
                    <img src="<?=static_sub('profile_pics/'.$news_feed_item->author->profile_pic)?>" height="25" width="25"/>
                  </a>
                </div>

                <div class="streamitem-main-container">
                  <div class="streamitem-tagbar placeleftpull">
                    <? foreach($news_feed_item->trips as $t):?>
                    <a href="<?=site_url('trips/'.$t->id)?>" class="tripname tag"><?=$t->name?></a>
                    <? endforeach;?>
                    <? foreach($news_feed_item->places as $p):?>
                    <a href="<?=site_url('places/'.$p->id)?>" class="place"><?=$p->name?></a>
                    <? endforeach;?>
                  </div>

                  <div class="author-container">
                    <div class="streamitem-name">
                      <a href="<? if($news_feed_item->author->username){echo site_url($news_feed_item->author->username);}else{echo site_url('profile/'.$news_feed_item->author->id);}?>"><?=$news_feed_item->author->name?></a>
                    </div>
                  </div>
                  <div style="clear:both"></div>
                  
                  <div class="streamitem-content">
                    <?=$news_feed_item->content?>
                  </div>                
  
                  <div class="actionbar">
                    <? if(isset($user->id)):?>
                    <a href="#" class="bar-item">Recommend</a>
                    <span class="bullet">&#149;</span>
                    <? endif;?>
                    <a class="bar-item show-comments" href="#"><? $num_comments=count($news_feed_item->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
                    <span class="bullet">&#149;</span>
                    <abbr class="bar-item timeago" title="<?=$news_feed_item->created?>"><?=$news_feed_item->created?></abbr>
                  </div>                
                  
                  <!--COMMENTS START-->
                  <div class="comments-container" style="display:none;">
                    <? foreach ($news_feed_item->replies as $reply):?>
                    <div class="comment">
                      <div class="comment-avatar-container">
                        <a href="<?=site_url('profile/'.$reply->user_id)?>">
                          <img src="<?=static_sub('profile_pics/'.$reply->author->profile_pic)?>" height="25" width="25"/>
                        </a>
                      </div>                      
                      <div class="comment-content-container">
                        <div class="streamitem-name">
                          <a href="<?=site_url('profile/'.$reply->user_id)?>"><?=$reply->author->name?></a>
                        </div> 
                        <div class="comment-content"><?=$reply->content?></div>
                        <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$reply->created?>"><?=$reply->created?></abbr></div>                      
                      </div>
                      <div style="clear:both"></div>
                    </div> 
                    <? endforeach;?>
                    <div class="comment-input-container">
                      <textarea class="comment-input-area"/></textarea>
                      <a class="add-comment-button" href="#">Add comment</a>
                    </div>  
                  </div><!--END COMMENT CONTAINER-->
                </div><!--END MAIN CONTAINER-->
              </div><!--END STREAMITEM-->
            <? endforeach;?>
            
          <? endif;?>
          </div>
        </div><!--TAB CONTAINER END-->
                    
      </div><!--LEFT CONTENT CONTAINER END-->     

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="col-right">          

      <div id="right-widgets">
        <div class="right-widget-container">                  
          <div id="stats-container"><!-- STATS -->
            <ul class="stats-list">
              <li><a href="#trips" class="trip-count"><?=$user->num_rsvp_yes_trips?><span class="stat-label">Trips</span></a></li>
              <li class="border-left"><a href="<?=site_url('profile/'.$user->id.'#posts')?>" class="post-count"><?=$user->num_posts?><span class="stat-label">Posts</span></a></li>
              <li class="border-left"><a href="<?=site_url('profile/'.$user->id.'#following')?>" class="following-count"><?=$user->num_following_users+$user->num_following_trips+$user->num_following_places?><span class="stat-label">Following</span></a></li>
              <li class="border-left"><a href="<?=site_url('profile/'.$user->id.'#followers')?>" class="followers-count"><?=$user->num_followers?><span class="stat-label">Followers</span></a></li>
            </ul>                
          </div><!--STATS END-->
          <div style="clear:both"></div>
        </div>
      </div><!-- RIGHT WIDGETS ENDS -->

      <!--RIGHT CONTENT-->      
      <div id="right-content-container">
        <? if($user->current_place):?>
        <div id="current-place" class="editable">
          <div class="edit-icon edit-curr-place"></div>
          <div class="right-item-name">Current Location</div>
          <a class="place placeleftpull" href="<?=site_url('places/'.$user->current_place->id)?>"><?=$user->current_place->name?><? if($user->current_place->country){echo ', '.$user->current_place->country;}?></a>
          
        </div>
        <? endif;?>
        <a href="#">Change</a>
       <!-- MAP -->
        <div id="map-shell">
          <div id="map-canvas"></div>
        </div><!--MAP ENDS-->
      </div>
    </div><!-- RIGHT COLUMN ENDS -->
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
<script type="text/javascript">
  $('.edit-icon').click(function() {
    if ($(this).siblings('input').length < 1) {
      var icon = $(this),
          input = $('<input id="edit-curr-place" type="text" style="width:250px"/>'),
          origPlace = icon.siblings('a');
      input.val(origPlace.text());
      origPlace.hide();
      icon.parent().append(input);
      input.focus();
    }
  });
  $('#current-place').click(function(e) {
    e.stopPropagation();
  });
  $('html').click(function() {
    $('.edit-icon').siblings('a').show();
    $('.edit-icon').siblings('input').remove();
  });
</script>
</body>
</html>