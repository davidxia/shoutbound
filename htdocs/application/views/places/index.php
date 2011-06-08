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
        'js/places/tabs.js',
        'js/follow.js',
        'js/user/loginSignup.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
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
      <div id="place-info">
        <div id="place-name"><?=$place->name?><? if($place->admin1):?><span id="admin1" style="display:none;"><?=$place->admin1?></span><? endif;?><? if($place->country):?>, <?=$place->country?><? endif;?>
        </div>
      </div>        
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
          <div class="nothingyet-copy">Nobody has shared a travel experience about <?=$place->name?> yet. You can be first!</div>
        <? endif;?>
        <? foreach ($place->posts as $post):?>
          <div class="post" id="post-<?=$post->id?>">
            <div class="postcontent">
              <?=$post->content?>
            </div>                      
            <div class="actionbar">
              <a class="post-profile-pic" href="<?=site_url('profile/'.$post->user_id)?>">
                <img src="<?=static_sub('profile_pics/'.$post->author->profile_pic)?>" height="22" width="22" alt="<?=$post->author->name?>"/>
              </a>
              <a href="<?=site_url('profile/'.$post->user_id)?>" class="author">
                <?=$post->author->name?>
              </a> 
              <a class="reply-button" href="#">Add comment</a>           
              <? if (isset($user->id) AND isset($post->likes[$user->id]) AND $post->likes[$user->id]):?>
                <a class="unlike-button" href="#">Unlike</a>
              <? else:?>
                <a class="like-button" href="#">Like</a>
              <? endif;?>
              <span class="num_likes"><? $num_likes=count(array_keys($post->likes,1)); echo $num_likes?><? if($num_likes ==1):?> person likes this<? else:?> people like this<? endif;?></span>
              <abbr class="timeago" title="<?=$post->created?>"><?=$post->created?></abbr>            
            </div> 
            <div class="remove-post"></div>
            <? foreach ($post->replies as $reply):?>
              <div class="post reply" id="post-<?=$reply->id?>">
                <div class="postcontent">
                  <?=$reply->content?>
                </div>
                <div class="actionbar">
                  <a href="<?=site_url('profile/'.$reply->user_id)?>" class="author"><?=$reply->user->name?></a>             
                  <? $is_liked = 0; foreach ($reply->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                    <? $is_liked = 1;?>
                  <? endif;?><? endforeach;?>
                  <? if ($is_liked == 0):?>
                    <a class="like-button" href="#">Like</a>
                  <? else:?>
                    <a class="unlike-button" href="#">Unlike</a>
                  <? endif;?>
                <? $num_likes = 0; foreach($reply->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>
                <abbr class="timeago" title="<?=$reply->created?>"><?=$reply->created?></abbr>
                </div>
                <div class="remove-post"></div>
              </div>
            <? endforeach;?>
          </div>
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
    <div id="abstract-container">
      <div class="right-item-name">About</div>
      <div id="abstract"></div>
      <div id="wikipedia-attribution">Source: Wikipedia</div>
    </div>
    
    <div id="map-shell">
      <div id="map-canvas"></div>     
    </div>
    
<!--
    <div id="gallery">
      <div class="right-item-name">Gallery</div>
    </div>
-->
  </div><!-- RIGHT COLUMN ENDS -->
     
  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div><!--STICKY FOOTER WRAPPER END-->
  <? $this->load->view('templates/footer')?>
</body>
</head>