<?php header("Content-type: text/html; charset=utf-8");
$header_args = array(
    'title' => $profile->name.' | Shoutbound',
    'css_paths' => array(
      'css/profile.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/follow.js',
        'js/common.js',
        'js/actionbar.js',
        'js/user/loginSignup.js',
        'js/jquery/popup.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var staticUrl = '<?=static_sub()?>';
  var profileId = <?=$profile->id?>;
  var isSelf = <? if ($is_self) echo 1; else echo 0;?>;
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
          <? foreach ($profile->recent_activities as $activity):?>
            <div id="activity-<?=$activity->id?>" class="streamitem <? if($is_self){echo 'deleteable';}?>">
            <? if($is_self):?><div class="delete"></div><? endif;?>
              <?=$profile->first_name?>
            <? if ($activity->activity_type==1):?>
              created <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a></span>
            <? elseif ($activity->activity_type==2):?>
              posted on <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a></span><br/>
              <?=$activity->post->content?>
              <h3>Actionbar needs to go here</<h3>
            <? elseif ($activity->activity_type==3):?>
               started following <span class="streamitem-name"><a href="<?=site_url('profile/'.$activity->following->id)?>"><?=$activity->following->name?></a></span>
               <h3>Follow/unfollow needs to go here</h3>              
            <? elseif ($activity->activity_type==4):?>
               started following <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a></span>
               <h3>Follow/unfollow needs to go here</h3>              
            <? elseif ($activity->activity_type==5):?>
               started following <span class="streamitem-name"><a href="<?=site_url('places/'.$activity->place->id)?>"><? echo $activity->place->name;if($activity->place->admin1){echo ', '.$activity->place->admin1;}if($activity->place->country){echo ', '.$activity->place->country;}?></a></span>
               <h3>Follow/unfollow needs to go here</h3>              
            <? elseif ($activity->activity_type==6):?>
               commented: <?=$activity->post->content?>
               <br/> in response to <?=$activity->post->author->name?>'s post: <?=$activity->post->content?>
               <h3>Follow/unfollow needs to go here</h3>              
            <? elseif ($activity->activity_type==8):?>
               is being followed by <span class="streamitem-name"><a href="<?=site_url('profile/'.$activity->follower->id)?>"><?=$activity->follower->name?></a></span>
               <h3>Follow/unfollow needs to go here</h3>              
            <? elseif ($activity->activity_type==9):?>
               updated his profile bio.
            <? elseif ($activity->activity_type==10):?>
              changed current location to <a href="<?=site_url('places/'.$activity->place->id)?>" class="place" lat="<?=$activity->place->lat?>" lng="<?=$activity->place->lng?>"><?=$activity->place->name?><? if($activity->place->admin1){echo ', '.$activity->place->admin1;}?><? if($activity->place->country){echo ', '.$activity->place->country;}?></a>
            <? endif;?>
<!--
            <br/>
            <abbr class="timeago" title="<?=$activity->timestamp?>"><?=$activity->timestamp?></abbr>
-->
            </div>
          <? endforeach;?>
        </div>          
      </div><!--TAB CONTAINER END-->
    </div><!--LEFT CONTENT END-->
  </div><!--LEFT COLUMN END-->

  <!-- RIGHT COLUMN -->
  <div id="col-right">
    <div id="profile-info">
      <div id="profile-pic-container">
        <a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="88" height="88"/></a>
      </div>
      <div id="profile-name"><?=$profile->name?></div>
      
      <? if (!$is_self AND !$is_following):?>
        <div id="actions-container">
          <a href="#" class="follow left" id="user-<?=$profile->id?>">Follow</a>
        </div>
      <? endif;?>
        
      <? if ($user AND !$is_self AND $is_following):?>
        <div id="actions-container">
          <a href="#" class="unfollow left" id="user-<?=$profile->id?>">Unfollow</a>
        </div>
      <? endif;?>

      <? if ($user AND $is_self):?>
        <div id="actions-container">
          <a class="edit-profile left" href="<?=site_url('settings/profile')?>">Edit profile</a>
        </div>
      <? endif;?>  

      <div style="clear:both"></div>        

      <div class="right-widget-container">       
        <div id="stats-container" class="right-widget-interior">
          <ul class="stats-list">
            <li><a href="#trail" class="trip-count"><?=$profile->num_rsvp_yes_trips?><span class="stat-label">Trips</span></a></li>
            <li class="border-left"><a href="#posts" class="post-count"><?=$profile->num_posts?><span class="stat-label">Posts</span></a></li>
            <li class="border-left"><a href="#following" class="following-count"><?=$profile->num_following_users+$profile->num_following_trips+$profile->num_following_places?><span class="stat-label">Following</span></a></li>
            <li class="border-left"><a href="#followers" class="followers-count"><?=$profile->num_followers?><span class="stat-label">Followers</span></a></li>
          </ul>
          <div style="clear:both"></div>        
        </div>            
      </div>      

      <div style="clear:both"></div>
      <div id="bio" class="profile-item">
        <?=$profile->bio?>
      </div>
      <div id="website" class="profile-item">
        <a href="<?=$profile->website?>" target="_blank"><?=$profile->website?></a>
      </div>
      
      <? if($profile->current_place):?>
      <div id="current-place" class="profile-item">
        <? if($is_self):?>
        <div class="edit-icon edit-curr-place"></div>
        <? endif;?>
        <div style="font-size:14px;font-weight:bold;margin-top:10px;">Current Location</div>
        <a href="<?=site_url('places/'.$profile->current_place->id)?>"><?=$profile->current_place->name?><? if($profile->current_place->admin1){echo ', '.$profile->current_place->admin1;}if($profile->current_place->country){echo ', '.$profile->current_place->country;}?></a>
      </div>
      <? endif;?>
      
      <? if($profile->future_places):?>
      <div id="future-places" class="profile-item">
        <? if($is_self):?>
        <div class="edit-icon edit-fut-places"></div>
        <? endif;?>
        <div style="font-size:14px;font-weight:bold;margin-top:10px;">Bucket List</div>
        <? foreach($profile->future_places as $future_place):?>
        <div>
          <a href="<?=site_url('places/'.$future_place->id)?>"><?=$future_place->name?><? if($future_place->admin1){echo ', '.$future_place->admin1;}if($future_place->country){echo ', '.$future_place->country;}?></a>
        </div>
        <? endforeach;?>
      </div>
      <? endif;?>

      <? if($profile->past_places):?>
      <div id="past-places" class="profile-item">
        <? if($is_self):?>
        <div class="edit-icon edit-past-places"></div>
        <? endif;?>
        <div style="font-size:14px;font-weight:bold;margin-top:10px;">Been To</div>
        <? foreach($profile->past_places as $past_place):?>
        <div>
          <a href="<?=site_url('places/'.$past_place->id)?>"><?=$past_place->name?><? if($past_place->admin1){echo ', '.$past_place->admin1;}if($past_place->country){echo ', '.$past_place->country;}?></a>
        </div>
        <? endforeach;?>
      </div>
      <? endif;?>
    </div>

    <!-- MAP -->
     <div id="map-shell">
       <div id="map-canvas"></div>
     </div>
      
  </div><!-- RIGHT COLUMN ENDS -->
                
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
<script type="text/javascript">
  $('.profile-item').hover(function() {
    $(this).children('.edit-icon').show();
  }, function() {
    $(this).children('.edit-icon').hide();
  });
  
  
  $('.edit-icon').click(function() {
    window.location = 'http://dev.shoutbound.com/david/settings/profile';
/*
    var icon = $(this),
        input = $('<input type="text" style="width:250px"/>');
    icon.parent().append(input);
    input.focus();
    
    if (icon.hasClass('edit-curr-place')) {
    } else if (icon.hasClass('edit-fut-places')) {
    }
*/
  });
</script>
</body> 
</html>