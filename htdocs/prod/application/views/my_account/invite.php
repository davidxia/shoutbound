<?php
$header_args = array(
    'title' => 'Invite | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('templates/core_header', $header_args);
?>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  <? if($user):?>
  var loggedin = true;
  <? endif;?>
</script>
</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  <h2>Invite your friends</h2>
  
  <div>
    <? if(isset($message)):?>
    <?=$message?>
    <? endif;?>
  </div>
    
  <div>
    <form action="<?=site_url('my_account/invite')?>" method="post">
      <div>
        <label for="first_name">Your first name (required):</label>
        <input type="text" id="first_name" name="first_name" value="<?=$user->first_name?>"/>
        <label for="last_name">Your last name (required):</label>
        <input type="text" id="last_name" name="last_name" value="<?=$user->last_name?>"/>
      </div>
      <div>
        <label for="friends_emails">Enter your friends&rsquo; emails below separated by commas.</label>
        <br/>
        <textarea cols="60" rows="10" id="friends_emails" name="friends_emails"></textarea>
      </div>
      <input type="submit" name="send" value="Send invites"/>
    </form>
  </div>

</div><!-- CONTENT ENDS -->
<div class="push"></div>
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>