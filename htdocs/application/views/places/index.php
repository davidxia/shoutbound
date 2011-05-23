<?php
$title = $place->name;
if ($place->admin1) $title .= ', '.$place->admin1;
if ($place->country) $title .= ', '.$place->country;
$header_args = array(
    'title' => $title.' | Shoutbound',
    'css_paths'=>array(
      'css/places.css'
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/jquery/jquery.ba-bbq.min.js',
        'js/places/tabs.js',
        'js/follow.js',
        'js/user/loginSignup.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<style type="text/css">
.compass .back{
  fill: #eee;
  fill-opacity: .8;
}
.compass .fore{
  stroke: #999;
  stroke-width: 1.5px;
}
.compass rect.back.fore{
  fill: #999;
  fill-opacity: .3;
  stroke: #eee;
  stroke-width: 1px;
  shape-rendering: crispEdges;
}
.compass .direction{
  fill: none;
}
.compass .chevron{
  fill: none;
  stroke: #999;
  stroke-width: 5px;
}
.compass .zoom .chevron{
  stroke-width: 4px;
}
.compass .active .chevron, .compass .chevron.active{
  stroke: #fff;
}
.compass.active .active .direction{
  fill: #999;
}
</style>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
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

  <div id="top-section"><!--TOP SECTION-->

    <div id="top-bar"><!--TOP BAR-->
      <div id="place-info">
        <div class="top-bar-header"><span id="place-name" class="place-page-header"><?=$place->name?></span></div>
        <? if($place->admin1):?><a class="destination tag" id="admin1"><?=$place->admin1?></a><? endif;?>
        <? if($place->country):?><a href="#" class="destination tag"><?=$place->country?></a><? endif;?>
  <? if($place->parent):?><a href="<?=site_url('places/'.$place->parent)?>"><?=$place->parent?></a><? endif;?>
        <div id="abstract"></div>  
      </div>
    </div><!--TOP BAR END-->
  
    <div id="right-widgets"><!--RIGHT WIDGETS-->
    
      <div class="right-widget-container">
        <div id="actions-container">                   
          <? if (!$user OR !$user->is_following):?>
            <a href="#" class="follow left" id="place-<?=$place->id?>">Follow</a>
          <? elseif ($user AND $user->is_following):?>
            <a href="#" class="unfollow left" id="<?=$place->id?>">Unfollow</a>
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
    
    </div><!--RIGHT WIDGETS END-->
  
    <div style="clear:both"></div>
  </div><!--TOP SECTION END-->
    
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

  <!-- RIGHT COLUMN -->
  <div id="col-right">      

    <!--RIGHT CONTENT-->      
    <div id="right-content-container">   
    
      <!-- GALLERY AND MAP-->
<!--
      <ul id="right-tabs">
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#map">Map</a></li>
      </ul>
-->
      
      <div class="right-tab-container">   
        
<!--         <div id="gallery-tab" class="right-tab-content"></div> -->
        
        <div id="map-tab" class="right-tab-content">
          <div id="map-canvas"></div>     
        </div>
      </div>
    
    </div><!--RIGHT CONTENT END-->
  </div><!-- RIGHT COLUMN ENDS -->

      
  </div><!-- WRAPPER ENDS -->
  </div><!-- CONTENT ENDS -->
  </div><!--STICKY FOOTER WRAPPER END-->
  <? $this->load->view('footer')?>
</body>
</head>