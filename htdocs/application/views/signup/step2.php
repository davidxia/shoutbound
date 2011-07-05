<?php
$header_args = array(
    'title' => 'Sign Up step 2 | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
        'js/signup.js',
    )
);

$this->load->view('templates/core_header', $header_args);
?>

</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  Invite your friends and get a chance to win a 4-night free stay at a Balinese resort.
  
  Connect via facebook, twitter, etc.
  
  
	<div id="fb-root"></div>
	<script>
    window.fbAsyncInit = function() {
      FB.init({appId: '136139119767617', status: true, cookie: true, xfbml: true});
    };
    (function() {
      var e = document.createElement('script'); e.async = true;
      e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
      document.getElementById('fb-root').appendChild(e);
    }());
	</script>
  <a href="#" id="fb_login_button">
  	<img src="<?=site_url('images/facebook-connect-button.png')?>" height="23" width="180"/>
	</a>
        	
  <div>
    <form action="<?=site_url('signup/finish')?>" method="post">
      <div>
        <label for="first_name">Your first name (required):</label>
        <input type="text" id="first_name" name="first_name" value="<?=$user->first_name?>"/>
        <label for="last_name">Your last name (required):</label>
        <input type="text" id="last_name" name="last_name" value="<?=$user->last_name?>"/>
      </div>
      <div>
        <label for="friends_emails">Or do enter friends&rsquo; emails below separated by commas.</label>
        <br/>
        <textarea cols="60" rows="10" id="friends_emails" name="friends_emails"></textarea>
      </div>
      <input type="submit" name="send" value="Send invites"/>
      <input type="submit" name="skip" value="skip"/>
    </form>
  </div>

</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
<script type="text/javascript">
  $(function() {
    $('#fb_login_button').click(function() {
      FB.login(function(d) {
        if (d.session) {
          facebookLogin();
        }
      }, {perms: 'email'});
      return false;
    });
  });
</script>
</html>