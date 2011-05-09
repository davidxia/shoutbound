<?php
$header_args = array(
    'title' => $profile->name.' | Shoutbound',
    'css_paths' => array(
      'css/profile.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/profile/map.js',
        'js/follow.js',
        'js/jquery/timeago.js',
        'js/user/loginSignup.js',
        'js/jquery/popup.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var profileId = <?=$profile->id?>;
  var isSelf = <? if ($is_self) echo 1; else echo 0;?>;
</script>
</head>

<body>
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

  <!-- RIGHT COLUMN -->
  <div id="col-right">      

    <? if (!$is_self AND !$is_following):?>
      <div class="right-widget-container">
        <div id="actions-container">
          <a href="#" class="follow left" id="user-<?=$profile->id?>">Follow</a>
         </div>
      </div>          
    <? endif;?>
        
    <? if ($user AND !$is_self AND $is_following):?>
      <div class="right-widget-container">
        <div id="actions-container">
          <a href="#" class="unfollow" id="user-<?=$profile->id?>">Unfollow</a>
         </div>
      </div>          
    <? endif;?>      


    <div class="right-widget-container">       
      <div id="stats-container" class="right-widget-interior">
        <ul class="stats-list">
          <li><a href="#trail" class="trip-count"><?=$profile->num_rsvp_yes_trips?><span class="stat-label">Trips</span></a></li>
          <li class="border-left"><a href="#posts" class="post-count"><?=$profile->num_posts?><span class="stat-label">Posts</span></a></li>
          <li class="border-left"><a href="#following" class="following-count"><?=$profile->num_following+$profile->num_following_trips?><span class="stat-label">Following</span></a></li>
          <li class="border-left"><a href="#followers" class="followers-count"><?=$profile->num_followers?><span class="stat-label">Followers</span></a></li>
        </ul>
        <div style="clear:both"></div>        
      </div>            
    </div>      
    
    <div style="clear:both"></div>  
    
    <!-- MAP -->
    <div id="map-shell" class="right-widget-container">
      <div id="map-canvas"></div>
    </div>
    
  </div><!-- RIGHT COLUMN ENDS -->


  <div id="top-bar"><!--TOP BAR-->
    <div id="profile-pic-container" class="img-container">
      <a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="125" height="125"/></a>
      <!--<a href="<?=site_url('settings/profile')?>" id="edit-profile-pic" style="position:absolute; top:0px; left:0px; font-size:12px; background-color:black; color:white; display:none;">change picture</a>-->
    </div>
    <div id="profile-info">
      <div class="top-bar-header"><?=$profile->name?></div>
      <div id="bio"><?=$profile->bio?></div>
      <div id="personal-url"><a href="<?=$profile->url?>" target="_blank"><?=$profile->url?></a></div>
      <? if ($user AND $is_self):?>
        <a class="subtext" href="<?=site_url('settings/profile')?>">Edit profile</a>
      <? endif;?>
    </div>
  </div><!--TOP BAR END-->

  <!-- LEFT COLUMN -->
  <div id="col-left">    
    
    <!--LEFT CONTENT-->      
    <div id="left-content-container">
      <ul id="main-tabs">
        <li><a href="#activity">Activity</a></li>
        <li><a href="#trail">Trail</a></li>
        <li><a href="#posts">Posts</a></li>
        <li><a href="#following">Following</a></li>
        <li class="last"><a href="#followers">Followers</a></li>
      </ul>
      
      <div style="clear:both"></div>
      
      <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        <div id="activity-tab" class="main-tab-content main-tab-default">
          <? foreach ($profile->activities as $activity):?>
            <div>
              <?=$profile->name?>
            <? if ($activity->activity_type==1):?>
              created a new trip called <a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a>
            <? elseif ($activity->activity_type==2):?>
              posted on <a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a><br/>
              <?=$activity->post->content?>
            <? elseif ($activity->activity_type==3):?>
              started following <a href="<?=site_url('profile/'.$activity->following->id)?>"><?=$activity->following->name?></a>
            <? elseif ($activity->activity_type==10):?>
              changed his current location to <a href="#"><?=$activity->place->name?></a>
            <? endif;?>
            <br/>
            <abbr class="timeago" title="<?=$activity->timestamp?>"><?=$activity->timestamp?></abbr>
            </div>
          <? endforeach;?>
        </div>          
      </div><!--TAB CONTAINER END-->
    </div><!--LEFT CONTENT END-->
  </div><!--LEFT COLUMN END-->
                
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('footer')?>
</body> 
</html>