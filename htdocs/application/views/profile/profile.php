<?php
$header_args = array(
    'title'=>$profile->name.' | Shoutbound',
    'css_paths'=>array(
      'css/profile.css',
    ),
    'js_paths'=>array(
        'js/profile/map.js',
        'js/jquery/timeago.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
  
</head>

<body>

<div id="header-content-wrapper">
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>

      <div id="profile-top-bar"><!--TOP BAR-->
        <div id="profile-pic-container">
          <a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="125" height="125"/></a>
          <a href="<?=site_url('profile/edit')?>" id="edit-profile-pic" style="position:absolute; top:-95px; left:0px; font-size:12px; background-color:black; color:white; display:none;">change picture</a>
        </div>
        
        <div id="profile-user-info">
          <h1><?=$profile->name?></h1>
          <div id="bio"><?=$profile->bio?></div>
          <div id="personal-url"><a href="<?=$profile->url?>" target="_blank"><?=$profile->url?></a></div>
        </div>
        
      </div><!--TOP BAR END-->
      
      <div id="follow-and-stats-container"><!--FOLLOW BUTTON + STATS-->
              
        <div id="stats-container">
          <ul class="stats-list">
            <li><a href="#trail" class="trip-count"><? $num_rsvp_yes_trips=count($profile->rsvp_yes_trips); echo $num_rsvp_yes_trips;?><span class="stat-label">Trips</span></a></li>
            <li class="border-left"><a href="#posts" class="post-count"><?=count($profile->posts)?><span class="stat-label">Posts</span></a></li>
            <li class="border-left"><a href="#following" class="following-count"><? $num_following=count($profile->following); echo $num_following;?><span class="stat-label">Following</span></a></li>
            <li class="border-left"><a href="#followers" class="followers-count"><? $num_followers=count($profile->followers); echo $num_followers;?><span class="stat-label">Followers</span></a></li>
          </ul>        
        </div>
        
        
        <div id="follow-button">
          <? if ($user AND !$is_self):?>
            <? if ( ! $is_following):?>
              <a href="#" id="follow">Follow</a>
            <? else:?>
              Following
            <? endif;?>
          <? endif;?>
        </div>        
        
      </div><!-- FOLLOW BUTTON + STATS END-->  
    
    <div style="clear:both"></div>  

    <!-- LEFT COLUMN -->
    <div id="profile-col-left">    
      
      <!--PROFILE MAIN CONTENT-->      
      <div id="profile-main-content-container">
      
        <ul class="main-tabs">
          <li><a href="#activity">Activity</a></li>
          <li><a href="#trail">Trail</a></li>
          <li><a href="#posts">Posts</a></li>
          <li><a href="#following">Following</a></li>
          <li><a href="#followers">Followers</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div class="tab-container"><!--TAB CONTAINER-->
              
          <div id="activity" class="main-tab-content">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </div>
          
          <div id="path" class="main-tab-content">
            <? foreach ($profile->rsvp_yes_trips as $trip):?>
              <div class="trip">
                <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                <? foreach ($trip->places as $place):?>
                  <span class="destination" lat="<?=$place->lat?>" lng="<?=$place->lng?>"><?=$place->name?></span>
                <? endforeach;?>
              </div>
            <? endforeach;?>
          </div>
          
          <div id="posts" class="main-tab-content">
            <? foreach ($profile->posts as $post):?>
              <div class="profile-feed-item">
                <? foreach ($post->trips as $trip):?>
                <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                <? endforeach;?>
                <div class="postcontent">
                  <?=$post->content?>
                </div>
                <abbr class="timeago" title="<?=$post->created?>"><?=$post->created?></abbr>
              </div>
            <? endforeach;?>
          </div>
          
          <div id="following" class="main-tab-content">
            <? foreach ($profile->following as $following):?>
            <div class="following">
              <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
            </div>
            <? endforeach;?>
          </div>
          
          <div id="followers" class="main-tab-content">
            <? foreach ($profile->followers as $follower):?>
            <div class="follower">
              <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
            </div>
            <? endforeach;?>
          </div>
          
        </div><!--TAB CONTAINER END-->
              
      
      </div><!--PROFILE MAIN CONTENT END-->
      
      

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="profile-col-right">      
      
      <!-- MAP -->
      <div style="display:none;">
        <? foreach ($profile->destinations as $destination):?>
          <a class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>"></a>
        <? endforeach;?>
      </div>
      <!--<? if ($user AND $is_self):?>
        <a href="<?=site_url('profile/edit')?>">Show off</a> where you've been.
      <? endif;?>-->
      <div id="map-shell">
          <div id="map-canvas" style="height:330px;"></div>
        </div>
      </div><!--MAP ENDS-->
      
    </div><!-- RIGHT COLUMN ENDS -->
            
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
</div><!-- HEADER CONTENT WRAPPER ENDS-->

  <? $this->load->view('footer')?>

<script type="text/javascript">
$(function() {
  $('abbr.timeago').timeago();
});

  $('#follow').click(function() {
    $.post('<?=site_url('friends/ajax_add_following')?>', {profileId: <?=$profile->id?>},
      function(data) {
        if (data == 1) {
          $('#follow').remove();
          $('#profile-col-right').prepend('Following');
        } else {
          alert('something broken, tell David');
        }
      });
    return false;
  });

  <? if ($is_self):?>
    $('#profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );
    $('#edit-profile-pic').hover(
      function() {
        $('#edit-profile-pic').show();
      },
      function() {
        $('#edit-profile-pic').hide();
      }
    );  
  <? endif;?>
  
$(document).ready(function() {

	//When page loads...
	$(".main-tab-content").hide(); //Hide all content
	$("ul.main-tabs li:first").addClass("active").show(); //Activate first tab
	$(".main-tab-content:first").show(); //Show first tab content

	//On Click Event
	$("ul.main-tabs li").click(function() {

		$("ul.main-tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".main-tab-content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).show(); //Fade in the active ID content
		return false;
	});


  //On Click Event-James
	$("ul.stats-list li a").click(function() {

    $("ul.main-tabs li").removeClass("active");
		var activeTab = $(this).attr('href');
		console.log(activeTab);
		$(".main-tab-content").hide();

		var activeTab = $(this).attr("href");
    $('.main-tabs').find('a[href='+activeTab+']').parent().addClass('active');
		$(activeTab).show();
		return false;
	});

});  
  
  
</script>

</body> 
</html>