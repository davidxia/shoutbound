<script type="text/javascript" src="http://dev.shoutbound.com/david/static/js/jquery/jquery.js"></script> 

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


<?
$trip_name = 'Congolese Merengue';
$content = "Hey, I need your help in planning my ".$trip_name." trip. <fb:req-choice url='http://dev.shoutbound.com/david/trips/1' label='Join'/>";
?>

<fb:serverfbml width="615">
  <script type="text/fbml">
    <fb:request-form action= '<?=site_url('trips/fb_friend_invite')?>'
                     method= 'POST'
                     invite= 'true'
                     type= 'Shoutbound'
                     content="<?=htmlentities($content,ENT_COMPAT,'UTF-8')?>">
      <fb:multi-friend-input/>
                                
      <fb:request-form-submit/>
      
    </fb:request-form>
  </script>
</fb:serverfbml>

