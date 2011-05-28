<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/onboarding.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/common.js',
        'js/user/loginSignup.js',
        'js/follow.js',
    )
);

$this->load->view('core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var uid = <?=$user->id?>;
</script>
</head>
	
<body>

<div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>

  <!--CONTENT-->
  <div class="onboarding-main"> 
    
    <div id="top-section">    
      <!--TOP-->
      <div id="onboarding-top">
        <div class="onboarding-header">1. Dream</div>
        <div class="onboarding-header activeheader">2. Follow</div>
        <div class="onboarding-header">3. Profile</div>    
      </div>
      <div class="onboarding-subtitle">Follow people, places and trips that interest you.</div>    
    </div>
  
    <!--LEFT-->
    <div id="onboarding-left">
      
      <ul id="main-tabs">
        <li class="active"><a href="#people">People</a></li>
        <li id="asdf"><a href="#trips">Trips</a></li>
        <li><a href="#places">Places</a></li>
      </ul>
              
      <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        <div id="people-tab" class="main-tab-content main-tab-default">
        
          <? if ($user->following):?>
            We've automatically followed for you these people on Shoutbound whom we think are your friends.
          <? endif;?>
          
          <? foreach ($other_users as $profile):?>
          <div class="streamitem">
            <a class="unfollow" id="user-<?=$profile->id?>" href="#">Unfollow</a>
            <div class="streamitem-avatar-container">
              <a href="<?=site_url('profile/'.$profile->id)?>">
                <img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" width="25" height="25"/>
              </a>
            </div>

            <div class="narrow streamitem-content-container">
              <div class="streamitem-name">
                <a href="<?=site_url('profile/'.$profile->id)?>"><?=$profile->name?></a>
              </div>
              <div class="streamitem-bio"><?=$profile->bio?></div>
              <div style="clear:both"></div>
            </div>
            
          </div>
          <? endforeach;?>
                     
        </div>
      </div>
          
    </div><!--LEFT END-->

    <!--RIGHT-->
    <div id="onboarding-right">
      <div id="follow-counter" class="right-widget-container">
        <div class="following-count"><?=$user->num_following+$user->num_following_trips+$user->num_following_places?></div>
        <span class="stat-label">Following</span>
      </div>
    
      <div id="walkthrough-text">
        We recommend that you follow at least 10 people, places, and trips.
      </div>
    
    </div><!--RIGHT ENDS-->    
        
    <div style="clear:both"></div>   
  </div><!--CONTENT END-->

</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
</div><!--STICK FOOTER WRAPPER ENDS-->
  
  <!--STICKY BAR-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="<?=site_url('signup/dream')?>" class="back-button">Back</a>
      <a href="#" class="next-button">Next</a> 
    </div>
  </div>        

</body>
<script type="text/javascript">
  var tabClicks = 0;
  $(window).bind('hashchange', function() {
    tabClicks++;
  });
  $('.next-button').click(function() {
    console.log(tabClicks);
    if (tabClicks == 1) {
      window.location = '<?=site_url('signup/follow#trips')?>';
    } else if (tabClicks == 2) {
      window.location = '<?=site_url('signup/follow#places')?>';
    } else {
      window.location = '<?=site_url('signup/profile')?>';
    }
    return false;
  });
</script>
</html>