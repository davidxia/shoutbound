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

  <!--LEFT NAVBAR-->
  <ul id="onboarding-navbar">
    <li>Dream</li>
    <li class="activeheader">Follow</li>
    <li>Profile</li>
    <li class="filler"></li>
  </ul>
  <!--LEFT NAVBAR END-->

  <div class="onboarding-main"> 
      <div id="onboarding-subtitle">Follow people, places and trips that interest you.</div>
      <div id="onboarding-copy">This connects you to content, blah blah lorem ipsum copy is your friend. The more you follow, the better your experience.  Inspire. We recommend that you follow at least 10 people, places, and trips. We pre-followed your facebook friends, dream travel destinations.
</div>     
        
      <ul id="main-tabs">
        <li class="active"><a href="#people">People</a></li>
        <li id="asdf"><a href="#trips">Trips</a></li>
        <li><a href="#places">Places</a></li>
      </ul>
              
      <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        <div id="people-tab" class="main-tab-content main-tab-default">
        
          <? foreach ($user->onboarding_users as $profile):?>
          <div class="streamitem">
            <a class="follow" id="user-<?=$profile->id?>" href="#">Follow</a>
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
            
    <div style="clear:both"></div> 
      
  </div><!--ONBOARDING MAIN END-->

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

  <!--RIGHT WIDGET-->
  <div id="follow-counter-container">
    <div id="follow-counter-content">
      <div id="follow-counter-second-layer">
        <div class="following-count"><?=$user->num_following_users+$user->num_following_trips+$user->num_following_places?></div>  
        <span class="stat-label">Following</span>
      </div>
    </div>
  </div><!--RIGHT WIDGET ENDS-->    


</body>
<script type="text/javascript">
  var tabClicks = 0;
  $(window).bind('hashchange', function() {
    tabClicks++;
  });
  $('.next-button').click(function() {
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