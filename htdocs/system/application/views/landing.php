<html>
<head>
    <title>ShoutBound</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>

<body>

<!-- FACEBOOK LOGIN BUTTON -->
<div id="fb-root"></div>
<script>
    FB.init({ appId:'136139119767617', cookie:true, status:true, xfbml:true });
</script>
<fb:login-button size="xlarge" autologoutlink='true' perms="publish_stream,email,user_checkins">You don't have to chew off your arm</fb:login-button>
      
      
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '136139119767617', status: true,
            cookie: true, xfbml: true
        });
        
		FB.Event.subscribe('auth.login', function(response) {
			login();
		});

		FB.getLoginStatus(function(response) {
			if (response.session) {
				greet();
			}
		});
    };
    (function() {
            var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
    }());
    
    
    // functions we call depending on user's facebook login status
    function login(){
		$.ajax({
            url: "<?=site_url('user/ajax_login');?>",
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
	}

	//if user is logged in via facebook and has allowed shoutbound as a
	//facebook app but isn't logged into Shoutbound
	//ie doesn't have shoutbound cookies, show shoutbound login
	function greet(){
		document.write("You are logged into Facebook but logged out of ShoutBound. Click <span id='shoutbound_login'>HERE</span> to log into ShoutBound.");
		$('#shoutbound_login').click(function(){
		    $.ajax({
                url: "<?=site_url('user/ajax_login');?>",
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

</body>
</html>
