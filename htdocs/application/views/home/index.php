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
            
              <li id="postitem-showing-comments" class="first-postitem postitem">
              
                <div class="postitem-avatar-container">
                  <a href="#">
                    <img src="http://upload.wikimedia.org/wikipedia/commons/b/b9/Steve_Jobs_Headshot_2010-CROP.jpg" class="tooltip" height="32" width="32" alt="username"/>
                  </a>
                </div>
                
                <div class="postitem-content-container">
                  <div class="postitem-author-name">
                    <a href="#">Steve Jobs</a>
                  </div> 
                  <div class="postitem-content">This is an example postitem to show David what it looks like when someone clicks "comments".  The postitem list item expands, pushes the feed down, and reveals the beatiful shiny comments below, along with the "add comment" form. If there are no comments, then the "X comments" link just says "Add comment" and clicking reveals the add comment form only. BTW, did you know that you know that 63% of all innovation in the United States is driven by me?</div>
                  <div class="postitem-actionbar">
                    <div id="repost-postitem" class="postitem-actionbar-item"><a href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <div id="add-postitem-comment" class="postitem-actionbar-item"><a href="#">3 Comments</a>
                    </div>
                    <span class="bullet">&#149</span>                    
                    <div class="postitem-actionbar-item"><a href="#">8 trips</a></div>
                    <span class="bullet">&#149</span>                        
                   <!--<? foreach($news_feed_item->trips as $trip):?>
                      <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                   <? endforeach;?>-->
                                       
                    <div class="postitem-actionbar-item"><abbr class="timeago subtext" title="#">timestamp</abbr></div>                        
                               
                  </div><!--END POSTITEM CONTENT CONTAINER--> 
                  
                  <div class="comments-container"><!--COMMENTS START-->
                    
                    <div class="comment">
                      <div class="postitem-avatar-container">
                        <a href="#">
                          <img src="http://upload.wikimedia.org/wikipedia/commons/2/2a/Bill_Gates_in_WEF_%2C2007.jpg" class="tooltip" height="32" width="32" alt="username"/>
                        </a>
                      </div>                      
                      <div class="comment-content-container">
                        <div class="comment-author-name">
                          <a href="#">Bill Gates</a>
                        </div> 
                        <div class="comment-content">Nigga, plz.  I is d original gangsta of the personal computer. You can't match my hustle.</div>
                        <div class="comment-timestamp"><abbr class="timeago subtext" title="#">timestamp</abbr></div>                      
                      </div>
                    </div> 

                    <div class="comment">
                      <div class="postitem-avatar-container">
                        <a href="#">
                          <img src="http://upload.wikimedia.org/wikipedia/commons/1/15/Mark_Zuckerberg_-_South_by_Southwest_2008_-_2-crop.jpg" class="tooltip" height="32" width="32" alt="username"/>
                        </a>
                      </div>                      
                      <div class="comment-content-container">
                        <div class="comment-author-name">
                          <a href="#">Mark Zuckerberg</a>
                        </div> 
                        <div class="comment-content">Psh. I will poke you both to death.</div>
                        <div class="comment-timestamp"><abbr class="timeago subtext" title="#">timestamp</abbr></div>                      
                      </div>
                    </div>                     

                    <div class="comment">
                      <div class="postitem-avatar-container">
                        <a href="#">
                          <img src="http://en.gravatar.com/userimage/19437443/ba9f2996753ba6ceab72b1ee750c793c.jpeg" class="tooltip" height="32" width="32" alt="username"/>
                        </a>
                      </div>                      
                      <div class="comment-content-container">
                        <div class="comment-author-name">
                          <a href="#">Thanasis Polychronakis</a>
                        </div> 
                        <div class="comment-content">I will geowarp you!</div>
                        <div class="comment-timestamp"><abbr class="timeago subtext" title="#">timestamp</abbr></div>                      
                      </div>
                    </div>                       
                      
                    <div class="comment-input-container">
                      <textarea class="comment-input-area"/></textarea>
                      <a id="add-comment-button" href="#">Add comment</a>
                    </div>  
                      
                  </div><!--END COMMENT CONTAINER-->
              
              </li>

              <li id="postitem-showing-trips" class="postitem">
                <div class="postitem-avatar-container">
                  <a href="#">
                    <img src="http://upload.wikimedia.org/wikipedia/commons/2/21/George_Hotz.jpg" class="tooltip" height="32" width="32" alt="username"/>
                  </a>
                </div>
                
                <div class="postitem-content-container">
                  <div class="postitem-author-name">
                    <a href="#">GeoHot</a>
                  </div> 
                  <div class="postitem-content">Yo whaddup David, this GeoHot.  I hacked into your dev site to show you what it should look like when a user clicks "X Trips" on a postitem.  All the trips it's added to appear in the format below.  If it's been added to no trips, then instead of "X trips", the item in the postitem actionbar should just say "Not added to any trips".  </div>
                  <div class="postitem-actionbar">
                    <div id="repost-postitem" class="postitem-actionbar-item"><a href="#">Add to trip</a>                      
                    </div>
                    <span class="bullet">&#149</span>
                    <div id="add-postitem-comment" class="postitem-actionbar-item"><a href="#">3 Comments</a>
                    </div>
                    <span class="bullet">&#149</span>                    
                    <div class="postitem-actionbar-item"><a href="#">2 trips</a></div>
                    <span class="bullet">&#149</span>                        
                   <!--<? foreach($news_feed_item->trips as $trip):?>
                      <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                   <? endforeach;?>-->
                                       
                    <div class="postitem-actionbar-item"><abbr class="timeago subtext" title="#">timestamp</abbr></div>                        
                               
                  </div><!--END POSTITEM CONTENT CONTAINER--> 
                  
                  <div class="trip-listing-container"><!--TRIP LISTING CONTAINER START-->              
                    <div class="trip-listing">
                      <div class="trip-listing-name"><a href="#">David visits GeoHot</a></div>
                      <div class="trip-listing-destination-container">
                        <span class="trip-listing-destination"><a href="#">San Francisco, CA</a></span>
                        <span class="bullet">&#149</span>
                        <span class="trip-listing-destination"><a href="#">Tokyo, Japan</a></span>
                      </div>
                    </div>           
            
                    <div class="trip-listing">
                      <div class="trip-listing-name"><a href="#">Help, I have been Geowarped and now I am lost</a></div>
                      <div class="trip-listing-destination-container">
                        <span class="trip-listing-destination"><a href="#">Javascript Hell, CA</a></span>
                        <span class="bullet">&#149</span>
                        <span class="trip-listing-destination"><a href="#">Boulder, CO</a></span>
                        <span class="bullet">&#149</span>
                        <span class="trip-listing-destination"><a href="#">San Francisco, CA</a></span>
                        <span class="bullet">&#149</span>
                        <span class="trip-listing-destination"><a href="#">Sparta, Greece</a></span>                        
                      </div>
                    </div>           
                  </div><!--TRIP LISTING CONTAINER END-->
              
              </li>
              
              <li id="newsitem-trip-created">
              
              
              
              </li>
            
              <? $first=TRUE; foreach($news_feed_items as $news_feed_item):?>
                <li id="postitem-<?=$news_feed_item->id?>" class="<? if($first):?><? echo 'first-postitem'; $first=FALSE;?><? endif;?> postitem">
                  <div class="postitem-avatar-container">
                    <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>">
                      <img src="<?=static_sub('profile_pics/'.$news_feed_item->user->profile_pic)?>" class="tooltip" height="32" width="32" alt="<?=$news_feed_item->user->name?>"/>
                    </a>
                  </div>                  
                  
                  <div class="postitem-content-container">
                    <div class="postitem-author-name">
                      <a href="<?=site_url('profile/'.$news_feed_item->user_id)?>"><?=$news_feed_item->user->name?></a>
                    </div> 
                    <div class="postitem-content"><?=$news_feed_item->content?></div>
                    <div class="postitem-actionbar">
                      <div id="repost-postitem" class="postitem-actionbar-item"><a href="#">Add to trip</a>                      
                      </div>
                      <span class="bullet">&#149</span>
                      <div id="add-postitem-comment" class="postitem-actionbar-item"><a href="#">3 Comments</a>
                      </div>
                      <span class="bullet">&#149</span>                    
                      <div class="postitem-actionbar-item"><a href="#">8 trips</a></div>
                      <span class="bullet">&#149</span>                        
                     <!--<? foreach($news_feed_item->trips as $trip):?>
                        <a href="<?=site_url('trips/'.($trip->id))?>"><?=$trip->name?></a>
                     <? endforeach;?>-->
                                         
                      <div class="postitem-actionbar-item"><abbr class="timeago subtext" title="<?=$news_feed_item->created?>"><?=$news_feed_item->created?></abbr></div>                        
                                 
                    </div>  
                    


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