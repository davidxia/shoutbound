<?php header("Content-type: text/html; charset=utf-8");
$header_args = array(
    'title' => $profile->name.' | Shoutbound',
    'css_paths' => array(
        'css/profile.css',
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/follow.js',
        'js/common.js',
        'js/actionbar.js',
        'js/user/loginSignup.js',
        'js/jquery/popup.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
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
  
    <div id="top-section">    
      <div id="profile-name"><?=$profile->name?></div>
    </div>
    
    <!--LEFT CONTENT-->      
    <div id="left-content-container">
      <ul id="main-tabs">
        <li><a href="#activity">Activity</a></li>
        <li><a href="#trips">Trips</a></li>
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
              created <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a>, a trip to</span>
            <? elseif ($activity->activity_type==2):?>
              posted on <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a>:</span>
              <div class="streamitem-content activity-indent">
                <?=$activity->post->content?> 
              </div>
              <div class="streamitem-tagbar placeleftpull">
              
              </div>
              
              <div class="actionbar">
              
              </div>
              
            <? elseif ($activity->activity_type==3):?>
               followed <span class="streamitem-name"><a href="<?=site_url('profile/'.$activity->following->id)?>"><?=$activity->following->name?></a></span>
            <? elseif ($activity->activity_type==4):?>
               followed <span class="streamitem-name"><a href="<?=site_url('trips/'.$activity->trip->id)?>"><?=$activity->trip->name?></a></span>
            <? elseif ($activity->activity_type==5):?>
               followed <span><a class="place" href="<?=site_url('places/'.$activity->place->id)?>"><? echo $activity->place->name;if($activity->place->country){echo ', '.$activity->place->country;}?></a></span>
               
            <? elseif ($activity->activity_type==6):?>
               commented on <?=$activity->post->author->name?>'s post: 
                <?=$activity->post->content?>             
               
            <? elseif ($activity->activity_type==10):?>
              is now in <a href="<?=site_url('places/'.$activity->place->id)?>" class="place" lat="<?=$activity->place->lat?>" lng="<?=$activity->place->lng?>"><?=$activity->place->name?><? if($activity->place->country){echo ', '.$activity->place->country;}?></a>
            <? endif;?>
<!--             <br/> -->
            <abbr class="timeago" title="<?=$activity->timestamp?>"><?=$activity->timestamp?></abbr>
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
        <div class="right-item-name">About</div>
        <?=$profile->bio?>
      </div>
      <div id="website" class="profile-item">
        <a href="<?=$profile->website?>" target="_blank"><?=$profile->website?></a>
      </div>
      
      <? if($profile->current_place):?>
      <div id="current-place" class="profile-item editable">
        <? if($is_self):?>
        <div class="edit-icon edit-curr-place"></div>
        <? endif;?>
        <div class="right-item-name">Current location</div>
        <a class="place placeleftpull right-item-entry" href="<?=site_url('places/'.$profile->current_place->id)?>"><?=$profile->current_place->name?><? if($profile->current_place->country){echo ', '.$profile->current_place->country;}?></a>
      </div>
      <? endif;?>
      
      <? if($profile->future_places):?>
      <div id="future-places" class="profile-item editable">
        <? if($is_self):?>
        <div class="edit-icon edit-fut-places"></div>
        <? endif;?>
        <div class="right-item-name">Dreaming of</div>
        <? foreach($profile->future_places as $future_place):?>
        <div class="right-item-entry">
          <a class="place placeleftpull" href="<?=site_url('places/'.$future_place->id)?>"><?=$future_place->name?><? if($future_place->country){echo ', '.$future_place->country;}?></a>
        </div>
        <? endforeach;?>
      </div>
      <? endif;?>

      <? if($profile->past_places):?>
      <div id="past-places" class="profile-item editable">
        <? if($is_self):?>
        <div class="edit-icon edit-past-places"></div>
        <? endif;?>
        <div class="right-item-name">Been to</div>
        <? foreach($profile->past_places as $past_place):?>
        <div class="right-item-entry">
          <a class="place placeleftpull" href="<?=site_url('places/'.$past_place->id)?>"><?=$past_place->name?><? if($past_place->country){echo ', '.$past_place->country;}?></a>
         <? if($past_place->timestamp):?>
           <?=date('n/Y', $past_place->timestamp)?>
         <? endif;?>
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