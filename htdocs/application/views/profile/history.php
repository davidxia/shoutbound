<?php
$header_args = array(
    'title' => 'History | Shoutbound',
    'css_paths'=>array(
    ),
    'js_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url()?>";
</script>
  
</head>

<body>

  <?=$this->load->view('header')?>
    
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

  
  <div class="wrapper">
    <div class="content" style="margin: 0 auto; width:960px; padding:20px 0 80px;">
    
      <a href="#" id="import-fb-data">import facebook data</a>
      <a href="#" id="import-tw-data">import twitter data</a>
      
      <div id="places"></div>
      
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <?=$this->load->view('footer')?>

<script type="text/javascript">
  $('#import-fb-data').click(function() {
    FB.login(function(response) {
      if (response.session) {
        $.ajax({
          type: 'POST',
          url: '<?=site_url('profile/facebook_history')?>',
          success: function(r) {
            $('#places').html(r);
          }
        });
      } else {
        alert('not logged in');
      }
    }, {perms: 'user_events, user_checkins'});
    return false;
  });
  
  
  $('#import-tw-data').click(function() {
    $.ajax({
      type: 'POST',
      url: '<?=site_url('profile/twitter_data')?>',
      success: function(r) {
        $('#places').html(r);
      }
    });
    
    return false;
  });

</script>

</body>
</head>