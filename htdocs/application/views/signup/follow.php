<?
$header_args = array(
    'title' => 'Getting Started | Shoutbound',
    'css_paths' => array(
        'css/uploadify.css',
        'css/onboarding.css',
    ),
    'js_paths' => array(
        'js/common.js',
        'js/uploadify/swfobject.js',
        'js/uploadify/jquery.uploadify.v2.1.4.min.js',
        'js/settings/profile.js',
        'js/follow.js',
        'js/user/loginSignup.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
        'js/jquery/jquery-dynamic-form.js',
        'js/jquery/validate.min.js',
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
        
          <!--DAVID FILL IN-->
          
<!--           <? if ($user->following):?> -->
            We've automatically followed for you these people on Shoutbound whom we think are your friends and the trips they're planning.
<!--           <? endif;?> -->
          
<!--           <? foreach ($user->following as $following):?> -->
          <div>
            <a href="<?=site_url('profile/'.$following->id)?>" target="_blank"><?=$following->name?></a>
            <a class="unfollow" id="user-<?=$following->id?>" href="#">Unfollow</a>
<!--             <? foreach ($following->trips as $trip):?> -->
            <div style="margin-left:20px;">
              <a href="<?=site_url('trips/'.$trip->id)?>" target="_blank"><?=$trip->name?></a>
<!--               <? foreach ($trip->goers as $goer):?> -->
              <a href="<?=site_url('profile/'.$goer->id)?>" target="_blank"><img src="<?=static_sub('profile_pics/'.$goer->profile_pic)?>" class="tooltip" width="35" height="35" alt="<?=$goer->name?>"/>
              <? endforeach;?>
              <a class="unfollow" id="trip-<?=$trip->id?>">Unfollow</a>
            </div>
<!--             <? endforeach;?> -->
          </div>
<!--           <? endforeach;?> -->
                     
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