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
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
    
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

  
    
    <a href="#" id="import-fb-data">import facebook data</a>
    <br/>
    <a href="#" id="import-tw-data">import twitter data</a>
    
    <div id="places"></div>
        
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->



  <? $this->load->view('footer')?>

<script type="text/javascript">
  $('#import-fb-data').click(function() {
    FB.login(function(response) {
      if (response.session) {
        $.ajax({
          url: '<?=site_url('profile/facebook_geohist')?>',
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
      url: '<?=site_url('profile/twitter_geohist')?>',
      success: function(r) {
        $('#places').html(r);
      }
    });
    
    return false;
  });

</script>

</body>
</head>