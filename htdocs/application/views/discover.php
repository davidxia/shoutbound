<?php header("Content-type: text/html; charset=utf-8");
$header_args = array(
    'title' => 'Discover | Shoutbound',
    'css_paths' => array(
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
  
  Who To Follow

  <? $i=1; foreach($users as $u):?>
  <div>
    <span><? echo $i; $i++;?>.</span>
    <div>
      Score: <?=$u->score?>, number of followers: <?=$u->num_followers?>, number of posts: <?=$u->num_posts?>, number of trips: <?=$u->num_rsvp_yes_trips?>
    </div>
    <div>
      <a href="<? if($u->username){echo site_url($u->username);}else{echo site_url('profile/'.$u->id);}?>">
        <img src="<?=static_sub('profile_pics/'.$u->profile_pic)?>" width="50" height="50"/>
      </a>
    </div>
    <div>
      <a href="<? if($u->username){echo site_url($u->username);}else{echo site_url('profile/'.$u->id);}?>"><?=$u->name?></a>
    </div>
    <div>
      <?=$u->bio?>
    </div>
    <? if (isset($u->is_following) AND $u->is_following):?>
      <a href="#" class="unfollow" id="user-<?=$u->id?>">Unfollow</a>
    <? elseif (!isset($user->id) OR $user->id != $u->id):?>
      <a href="#" class="follow" id="user-<?=$u->id?>">Follow</a>
    <? endif;?>
  </div>
  <? endforeach;?>
  
  
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICK FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body> 
</html>