<?php header("Content-type: text/html; charset=utf-8");
$header_args = array(
    'title' => 'Discover | Shoutbound',
    'css_paths' => array(
      'css/discover.css',
    ),
    'js_paths' => array(
        'js/follow.js',
        'js/common.js',
        'js/user/loginSignup.js',
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
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>  
    <div id="col-left">
      <div id="discover-headline">Discover the top Shoutbound users!</div>
      <div id="leaderboard-contents"><!--LEADERBOARD CONTENTS-->
        <ul id="leaderboard-toprow">
          <li id="leaderboard-category-rank">Rank</li>
          <li id="leaderboard-category-name">Name</li>
          <li id="leaderboard-category-score">Score</li>
          <li id="leaderboard-category-posts">Posts</li>
          <li id="leaderboard-category-trips">Trips</li>
          <li id="leaderboard-category-followers">Followers</li>
        </ul>
        <div style="clear:both"></div>     
        <? $i=1; foreach($users as $u):?>
          <ul class="leaderboard-entry"><!--NEW ENTRY-->
            <li class="leaderboard-entry-rank"><? echo $i; $i++;?>.</li>
            <li class="leaderboard-entry-avatar-container">
              <a href="<? if($u->username){echo site_url($u->username);}else{echo site_url('profile/'.$u->id);}?>">
                <img src="<?=static_sub('profile_pics/'.$u->profile_pic)?>" width="50" height="50"/>
              </a>
            </li>
            <li class="leaderboard-entry-username">
              <a style="color:#333;" href="<? if($u->username){echo site_url($u->username);}else{echo site_url('profile/'.$u->id);}?>"><?=$u->name?></a>
            </li>
            <li class="leaderboard-entry-score"><?=$u->score?></li> 
            <li class="leaderboard-entry-posts"><?=$u->num_posts?></li>
            <li class="leaderboard-entry-trips"><?=$u->num_rsvp_yes_trips?></li>
            <li class="leaderboard-entry-followers"><?=$u->num_followers?></li>
            <li class="leaderboard-entry-followbuttons">          
              <? if (isset($u->is_following) AND $u->is_following):?>
                <a href="#" class="unfollow" id="user-<?=$u->id?>">Unfollow</a>
              <? elseif (!isset($user->id) OR $user->id != $u->id):?>
                <a href="#" class="follow" id="user-<?=$u->id?>">Follow</a>
              <? endif;?>
            </li>
          </ul><!--END ENTRY-->
          <div style="clear:both"></div>                        
        <? endforeach;?>        
      </div><!--END LEADERBOARD CONTENTS-->
    </div><!--CLOST COL LEFT-->
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body> 
</html>
<!--
            <div class="streamitem-bio">
              <?=$u->bio?>
            </div>
-->