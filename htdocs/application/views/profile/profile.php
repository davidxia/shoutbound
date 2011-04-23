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

    <!-- LEFT COLUMN -->
    <div id="profile-col-left">
    
      <div id="profile-top-bar">
        <div id="profile-pic-container">
          <a href="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" id="profile-pic"><img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="125" height="125"/></a>
          <a href="<?=site_url('profile/edit')?>" id="edit-profile-pic" style="position:absolute; top:-95px; left:0px; font-size:12px; background-color:black; color:white; display:none;">change picture</a>
        </div>
        
        <div id="profile-user-info">
          <h1><?=$profile->name?></h1>
          <div id="bio">User bio here </div>
          <div id="personal-url">User URL here</div>
          <div style="clear:both"></div>
        </div>
        
      </div><!--TOP BAR END-->     
      
      <!--PROFILE MAIN CONTENT-->      
      <div id="profile-main-content-container">
      
        <ul class="main-tabs">
          <li class="active"><a href="#">Activity</a></li>
          <li><a href="#">Posts</a></li>
          <li><a href="#">Following</a></li>
          <li><a href="#">Followers</a></li>
        </ul>
        
        <div class="tab-container"><!--TAB CONTAINER-->
              
          <div id="profile-feed-tab-content" class="main-tab-content">
            <? foreach ($profile_feed_items as $profile_feed_item):?>
              <div class="profile-feed-item">
                <? foreach ($profile_feed_item->trips as $trip):?>
                <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
                <? endforeach;?>
                <div class="content">
                  <?=$profile_feed_item->content?>
                </div>
                <abbr class="timeago" title="<?=$profile_feed_item->created?>"><?=$profile_feed_item->created?></abbr>
              </div>
            <? endforeach;?>
          </div>
          
          <div id="profile-posts-tab-content" class="main-tab-content">
          
          </div>
          
          <div id="profile-following-tab-content" class="main-tab-content">
          
          </div>
          
          <div id="profile-followers-tab-content" class="main-tab-content">
          
          </div>
          
        </div><!--TAB CONTAINER END-->
              
      
      </div><!--PROFILE MAIN CONTENT END-->
      
      

    </div><!--LEFT COLUMN END-->
    
    <!-- RIGHT COLUMN -->
    <div id="profile-col-right">
      <? if ($user AND !$is_self):?>
        <? if ( ! $is_following):?>
          <a href="#" id="follow">FOLLOW</a>
        <? else:?>
          Following
        <? endif;?>
      <? endif;?>
      
      <!-- MAP -->
      <div style="display:none;">
        <? foreach ($profile->destinations as $destination):?>
          <a class="destination" lat="<?=$destination->lat?>" lng="<?=$destination->lng?>"></a>
        <? endforeach;?>
      </div>
      <? if ($user AND $is_self):?>
        <a href="<?=site_url('profile/edit')?>">Show off</a> where you've been.
      <? endif;?>
      <div id="map-shell" style="padding:5px;">
        <div class="right-item-content" style="background-color:white; padding:3px; border:1px solid #EAEAEA;">
          <div id="map-canvas" style="height:312px;"></div>
        </div>
      </div>
      
      <!-- TRIPS CONTAINER -->
      <div id="profile-page-trips-container" style="width:320px;">
        <div id="profile-page-trips-list-header">
          Trips: (<?=count($trips)?>)
        </div>  
        <div id="profile-page-trips-list-content"><!-- TRIPS -->
          <? foreach ($trips as $trip):?>
            <div class="trip">
              <a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a>
              <? foreach ($trip->places as $place):?>
                <span class="destination" lat="<?=$place->lat?>" lng="<?=$place->lng?>"><?=$place->name?></span>
              <? endforeach;?>
            </div>
          <? endforeach;?>
        </div><!-- TRIPS LIST END -->
      </div><!-- TRIPS CONTAINER ENDS -->

      <!-- FOLLOWERS CONTAINER -->
      <div>
        <div>
          Followers (<?=count($profile->followers)?>)
        </div>
        <div>
          <? foreach ($profile->followers as $follower):?>
          <div class="follower">
            <a href="<?=site_url('profile/'.$follower->id)?>"><?=$follower->name?></a>
          </div>
          <? endforeach;?>
        </div>
      </div><!-- FOLLOWERS CONTAINER ENDS -->
        
      <!-- FOLLOWING CONTAINER -->
      <div>
        <div>
          Following (<?=count($profile->following)?>)
        </div>
        <div>
          <? foreach ($profile->following as $following):?>
          <div class="following">
            <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
          </div>
          <? endforeach;?>
        </div>
      </div><!-- FOLLOWING CONTAINER ENDS -->
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
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});  
  
  
</script>

</body> 
</html>