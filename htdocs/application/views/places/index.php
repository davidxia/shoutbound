<?php
$title = $place->name;
if ($place->country) $title .= ', '.$place->country;
$header_args = array(
    'title' => $title.' | Shoutbound',
    'css_paths'=>array(
        'css/places.css',
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/jquery/jquery.ba-bbq.min.js',
        'js/places.js',
        'js/follow.js',
        'js/user/loginSignup.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/actionbar.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticUrl = '<?=static_sub()?>';
  var placeId = <?=$place->id?>;
  var lat = <?=$place->lat?>;
  var lng = <?=$place->lng?>;
  var swLat = <?=$place->sw_lat?>;
  var swLng = <?=$place->sw_lng?>;
  var neLat = <?=$place->ne_lat?>;
  var neLng = <?=$place->ne_lng?>;
</script>
</head>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
    
  <!-- LEFT COLUMN -->
  <div id="col-left">    
    <div id="top-section"><!--TOP SECTION-->
      <div id="place-title">
        <span id="place-name"><?=$place->name?></span><? if($place->country):?>, <?=$place->country?><? endif;?>
      </div>
      <? if($place->admin1):?><span id="admin1" style="display:none;"><?=$place->admin1?></span><? endif;?>
    </div><!--TOP SECTION END-->  
    
    <ul id="main-tabs">
      <li><a href="#posts">Posts</a></li>
      <li><a href="#trips">Trips</a></li>
      <li><a href="#followers">Followers</a></li>
      <li><a href="#related_places">Related Places</a></li>
    </ul>
            
    <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
      <div id="posts-tab" class="main-tab-content main-tab-default">
        <? if(!$place->posts):?>
          <div class="nothingyet-copy">Nobody has shared a travel experience about <?=$place->name?> yet. You can be the first!</div>
        <? endif;?>
        
        <? $prefix='first-item'; foreach ($place->posts as $post):?>
          <div class="<?=$prefix?> streamitem" id="post-<?=$post->id?>"><? $prefix=''?>
            <div class="streamitem-avatar-container">
              <a href="<? if($post->author->username){echo site_url($post->author->username);}else{echo site_url('profile/'.$post->user_id);}?>">
                <img src="<?=static_sub('profile_pics/'.$post->author->profile_pic)?>" height="25" width="25"/>
              </a>
            </div>
            
            <div class="streamitem-main-container">              
              <div class="streamitem-tagbar placeleftpull">
                <? foreach($post->trips as $t):?>
                <a href="<?=site_url('trips/'.$t->id)?>" class="tripname tag"><?=$t->name?></a>
                <? endforeach;?>
                <? foreach($post->places as $p):?>
                <a href="<?=site_url('places/'.$p->id)?>" class="tripname tag"><?=$p->name?></a>
                <? endforeach;?>
              </div>

              <div class="author-container">
                <div class="streamitem-name">
                  <a href="<? if($post->author->username){echo site_url($post->author->username);}else{echo site_url('profile/'.$post->author->id);}?>"><?=$post->author->name?></a>
                </div>
              </div>
              <div class="streamitem-content">
                <?=$post->content?>
              </div>             

              <div class="actionbar">
                <? if(isset($user->id)):?>
                <a href="#" class="bar-item">Recommend</a>
                <span class="bullet">&#149;</span>
                <? endif;?>
                <a class="bar-item show-comments" href="#"><? $num_comments=count($post->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
                <span class="bullet">&#149;</span>
                <abbr class="bar-item timeago" title="<?=$post->created?>"><?=$post->created?></abbr>
              </div>

              <!--COMMENTS START-->
              <div class="comments-container" style="display:none;">
                <? foreach ($post->replies as $comment):?>
                <div class="comment">
                  <div class="streamitem-avatar-container">
                    <a href="<?=site_url('profile/'.$comment->user_id)?>">
                      <img src="<?=static_sub('profile_pics/'.$comment->author->profile_pic)?>" height="28" width="28"/>
                    </a>
                  </div>                      
                  <div class="streamitem-content-container">
                    <div class="streamitem-name">
                      <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->author->name?></a>
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
              </div><!--END COMMENTS -->                
            </div><!-- END MAIN CONTAINER -->
          </div><!-- END POST -->
        <? endforeach;?>
      </div>          
    </div><!--TAB CONTAINER END-->
  </div><!--LEFT COLUMN END-->

  <!-- RIGHT COLUMN -->
  <div id="col-right">
        
    <div id="actions-container">                   
      <? if (!$user OR !$place->is_following):?>
        <a href="#" class="follow left" id="place-<?=$place->id?>">Follow</a>
      <? elseif ($user AND $place->is_following):?>
        <a href="#" class="unfollow left" id="place-<?=$place->id?>">Unfollow</a>
      <? endif;?>
      <div style="clear:both;"></div>
    </div>
    <div class="right-widget-container">
      <div id="stats-container" class="right-widget-interior">
        <ul class="stats-list">
          <li><a href="#posts" class="num-posts"><?=$place->num_posts?><span class="stat-label">Posts</span></a></li>
          <li class="border-left"><a href="#trips" class="num-trips"><?=$place->num_trips?><span class="stat-label">Trips</span></a></li>
          <li class="border-left"><a href="#followers" class="num-followers"><?=$place->num_followers?><span class="stat-label">Followers</span></a></li>
        </ul>        
      </div>
      <div style="clear:both"></div>
    </div>
    <div id="abstract-container" style="display:none;">
      <div class="right-item-name">About</div>
      <div id="abstract"></div>
      <div id="wikipedia-attribution">Source: Wikipedia</div>
    </div>
    
    <div id="map-shell">
      <div id="map-canvas"></div>     
    </div>
    
    <div id="gallery">
      <div class="right-item-name">Gallery</div>
    </div>
  </div><!-- RIGHT COLUMN ENDS -->
     
  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div><!--STICKY FOOTER WRAPPER END-->
  <? $this->load->view('templates/footer')?>
</body>
</head>