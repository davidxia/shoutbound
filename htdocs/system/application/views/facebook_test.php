<!DOCTYPE html> 
<html> 
  <head> 
    <title>ShoutBound</title> 
 
    <!-- LIBRARIES --> 
    <link rel="stylesheet" href="http://dev.shoutbound.com/david/static/css/common.css" type="text/css" media="screen" charset="utf-8"></script> 
    <script type="text/javascript" src="http://dev.shoutbound.com/david/static/js/jquery/jquery.js"></script> 
    
  </head>
  
  <body>
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
    
    
    <a id="test" href="#">Publish to profile</a>
    <a id="test2" href="#">send friends a request</a>
  </body>


<?
$trip_name = 'Congolese Merengue';
$content = "Hey, I need your help in planning my ".$trip_name." trip.";
//$content = '<a href="http://dev.shoutbound.com/david">easssss</a>';
?>

  <script>
  $(document).ready(function() {
    $('#test').click(function() {
      FB.ui({
        method: 'feed',
        name: 'I need your help to plan my trip',
        link: 'http://www.shoutbound.com/',
        picture: '<?=site_url('images/sb_logo_75.jpg')?>',
        caption: 'Shoutbound is bi-winning, duh.',
        description: 'Tell all your fuckin\' friends about Shoutbound.',
        message: 'Shit yeah, I just prefilled your message body.'
      },
      function(response) {
        if (response && response.post_id) {
          alert('Post was published.');
        } else {
          alert('Post was not published.');
        }
      });
      return false;
    });
    
    $('#test2').click(function() {
      FB.ui({
        method: 'apprequests',
        title: 'Invite your friends on this trip.',
        message: '<?=$content?>',
        data: 'tracking information for the user'
      });
      return false;
    });
  });
  
  </script>
  
</html>