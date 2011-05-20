<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/dream.css',
    ),
    'js_paths' => array(
        'js/jquery/jquery.ba-bbq.min.js',
        'js/common.js',
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

  <!--CONTENT-->
  <div class="onboarding-main"> 
    
    <!--TOP-->
    <div id="onboarding-top">
      <div class="onboarding-header">1. Dream</div>
      <div class="onboarding-header activeheader">2. Follow</div>
      <div class="onboarding-header">3. Profile</div>    
    </div>
    
    <!--LEFT-->
    <div id="onboarding-wideleft">
      <div class="onboarding-subtitle">Follow the people, places and trips that interest you.</div>    
      
      <ul id="main-tabs">
        <li class="active"><a href="#people">People</a></li>
        <li><a href="#places">Places</a></li>
        <li><a href="#trips">Trips</a></li>
      </ul>
              
      <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
        <div id="people-tab" class="main-tab-content main-tab-default">
        
          <? if ($user->following):?>
            We've automatically followed for you these people on Shoutbound whom we think are your friends.
          <? endif;?>
          
          <? foreach ($user->following as $following):?>
          <div class="streamitem">
            <a class="unfollow" id="user-<?=$following->id?>" href="#">Unfollow</a>
            <div class="streamitem-avatar-container">
              <a href="<?=site_url('profile/'.$following->id)?>">
                <img src="<?=static_sub('profile_pics/'.$following->profile_pic)?>" width="25" height="25"/>
              </a>
            </div>

            <div class="narrow streamitem-content-container">
              <div class="streamitem-name">
                <a href="<?=site_url('profile/'.$following->id)?>"><?=$following->name?></a>
              </div>
              <div class="streamitem-bio"><?=$following->bio?></div>
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
        <div class="following-count">13</div>
        <span class="stat-label">Following</span>
      </div>
    
      <div id="walkthrough-text">
        We recommend that you follow at least 10 people, places and trips. Revise to explain pulling facebook etc.
      </div>
    
    </div><!--RIGHT ENDS-->    
        
    <div style="clear:both"></div>   
  </div><!--CONTENT END-->
  
  <!--PROGRESS BUTTONS-->
  <div id="sticky-bar">  
    <div id="progress-buttons-container">
      <a href="<?=site_url('signup/onboarding')?>" class="back-button">Back</a>
      <a href="<?=site_url('signup/profile')?>" class="next-button">Next</a> 
    </div>
  </div>        

</body>
</html>