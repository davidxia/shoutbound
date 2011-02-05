<html>
<head>
    <title>ShoutBound</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>


<body>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '136139119767617', status: true, cookie: true,
             xfbml: true});
             
	FB.getLoginStatus(function(response) {
		if (response.session) {
			shoutboundLogin();
		} else {
		    facebookLogin();
		}
	});
	
    // if user logs into facebook on our landing page, show shoutbound login
	FB.Event.subscribe('auth.login', function(response) {
		shoutboundLogin();
	});
	
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>      
      
<script>

    
    
    // if user is not logged into facebook, show facebook login button
    function facebookLogin(){
        $('#facebook-login-button').show();
	}

	// if user is logged into facebook and has allowed shoutbound as a
	// facebook app but isn't logged into Shoutbound
	// ie doesn't have shoutbound cookies, show shoutbound login
	function shoutboundLogin(){
		document.write("You are logged into Facebook but logged out of ShoutBound. Click <span id='shoutbound_login'>HERE</span> to log into ShoutBound.");
		$('#shoutbound_login').click(function(){
		    $.ajax({
                url: "<?php echo site_url('user/ajax_login');?>",
                type: "POST",
                dataType: "json",
                success: function(data) {
                    if(data['success']) {
                        window.location = data['redirect'];
                    } else {
                        alert(data['message']);
                    }
                }
            });
		});
	}
</script>

<!-- FACEBOOK LOGIN BUTTON -->
<div id="facebook-login-button" style="display: none">
    <fb:login-button size="xlarge" perms="publish_stream,email,user_checkins">You don't have to chew off your arm</fb:login-button>
</div>

</body>
</html>
