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
        <input type="submit" val="Send invites"/>
      </form>
    </div>

</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>