<?php
$header_args = array(
    'title' => $place->name.', '.$place->admin1.', '.$place->country.' | Shoutbound',
    'css_paths'=>array(
      'css/places.css'
    ),
    'js_paths'=>array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/places/map.js',
        'js/places/tabs.js',
        'js/jquery/timeago.js',
        'js/follow.js',
        'js/user/loginSignup.js',
    )
);
$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var placeId = <?=$place->id?>;
  map.lat = <?=$place->lat?>;
  map.lng = <?=$place->lng?>;
  map.swLat = <?=$place->sw_lat?>;
  map.swLng = <?=$place->sw_lng?>;
  map.neLat = <?=$place->ne_lat?>;
  map.neLng = <?=$place->ne_lng?>;
</script>
</head>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

  <!-- RIGHT COLUMN -->
  <div id="col-right">      

    <div class="right-widget-container">
      <div id="actions-container"><!--ACTIONS CONTAINER-->                    
        <? if (!$user OR !$user->is_following):?>
          <a href="#" class="follow left" id="place-<?=$place->id?>">Follow</a>
        <? elseif ($user AND $user->is_following):?>
          <a href="#" class="unfollow" id="<?=$place->id?>">Unfollow</a>
        <? endif;?>
      </div>
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
    
    <!-- GALLERY AND MAP-->
<!--
    <ul id="right-tabs">
      <li><a href="#gallery">Gallery</a></li>
      <li><a href="#map">Map</a></li>
    </ul>
-->
    
<!--
    <div class="right-tab-container img-container" style="height:340px;">
      <div id="gallery-tab" class="right-tab-content">
      </div>
-->
    <div id="map-shell" class="right-widget-container">
      <div id="map-canvas"></div>
    </div>
    
  </div><!-- RIGHT COLUMN ENDS -->

  <div id="top-bar"><!--TOP BAR-->
    <div id="place-info">
      <div class="top-bar-header"><span id="place-page-header"><?=$place->name?></span></div>
      <a class="destination tag" id="admin1"><?=$place->admin1?></a>
      <a href="#" class="destination tag"><?=$place->country?></a>
<!--       <div id="abstract"></div> -->
    </div>
    </div><!--TOP BAR END-->
    
  <!-- LEFT COLUMN -->
  <div id="col-left">    
    
    <!--LEFT COLUMN CONTENT-->      
    <div id="left-content-container">
      <ul id="main-tabs">
        <li><a href="#posts">Posts</a></li>
        <li><a href="#trips">Trips</a></li>
        <li><a href="#followers">Followers</a></li>
      </ul>
              
      <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        <div id="posts-tab" class="main-tab-content main-tab-default">
          <? foreach ($place->posts as $post):?>
            <div class="post" id="post-<?=$post->id?>">
              <div class="postcontent">
                <?=$post->content?>
              </div>             
              
              <div class="actionbar">
                <a class="post-profile-pic" href="<?=site_url('profile/'.$post->user_id)?>">
                  <img src="<?=static_sub('profile_pics/'.$post->user->profile_pic)?>" height="22" width="22" alt="<?=$post->user->name?>"/>
                </a>
                <a href="<?=site_url('profile/'.$post->user_id)?>" class="author">
                  <?=$post->user->name?>
                </a> 
                <a class="reply-button" href="#">Add comment</a>           
                <? $is_liked = 0; foreach ($post->likes as $like):?><? if (isset($user) AND $like->user_id==$user->id AND $like->is_like==1):?>
                  <? $is_liked = 1;?>
                <? endif;?><? endforeach;?>
                <? if ($is_liked == 0):?>
                  <a class="like-button" href="#">Like</a>
                <? else:?>
                  <a class="unlike-button" href="#">Unlike</a>
                <? endif;?>
                <? $num_likes = 0; foreach($post->likes as $like) {if ($like->is_like==1) {$num_likes++;}}?><? if ($num_likes == 1):?><span class="num-likes"><?=$num_likes?> person likes this</span><? elseif ($num_likes > 1):?><span class="num-likes"><?=$num_likes?> people like this</span><? endif;?>
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
    </div><!--LEFT COLUMN CONTENT END-->
  </div><!--LEFT COLUMN END-->
      
  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div>
  <? $this->load->view('footer')?>
</body>
</head>