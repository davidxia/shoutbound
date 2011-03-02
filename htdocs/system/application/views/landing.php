<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<title>Shoutbound!</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	</head>
	
	<body><!--main start-->
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
		
		<div id="main" style="background:url('<?=site_url('images/hills.png')?>'); background-repeat:no-repeat; height:761px; width:960px;">
			<!--<div id="sign-in" style="background:url('<?=site_url('images/signin.png')?>'); background-repeat:no-repeat; height:50px; width:150px; z-index:2; position:relative; top:15px; left:625px; float:left; display:inline-block;"></div>-->
			<a href="#" id="fb_login_button">
				<div id="log-in" style="background:url('<?=site_url('images/login.png')?>'); background-repeat:no-repeat; height:50px; width:150px; z-index:2; position:relative; top:25px; left:725px; float:left; display:inline block;"></div>
			</a>
			<!--<div id="headline" style="font: 22px lucida grande; font-weight: bold; color:#000090; position:absolute; top:135px; left:130px;">Shoutbound helps people collaborate to make travel plans.</div>-->

			
			<div id="box" style="background: black; opacity:0.65; height:500px; position:absolute; top:160px; left: 340px; border-radius: 10px; width:580px;"></div>
			
			<div id="logo" style="background:url('<?=site_url('images/logo_big.png')?>'); background-repeat:no-repeat; position:absolute; top:215px; left: 60px; height:200px; width:300px;"></div>
			
			<div id="headline" style="position:absolute; top:180px; left:380px; width:520px; font: 30px lucida grande; font-weight: bold; color:white; padding-left:10px; padding-right:10px; padding-top:30px;">Collaborative travel planning.</div>

			<div id="bar"><form><input style="border-radius:15px; box-shadow:  0 0 5px 5px #888; -webkit-box-shadow:  0 0 5px 5px #888; background-color:white; position:absolute; top:285px; left:410px;z-index:3; height:50px; width:410px; padding-right:100px; border: 5px solid gray; padding-top: 10px; padding-left:15px; padding-bottom:5px; font:25px lucida grande; font-weight: bold; color:#000080;"type="text" value="Where do you want to go?"</form>
				<!--<div id="baricon" style="background:url('<?=site_url('images/baricon.png')?>'); background-repeat:no-repeat; z-index:5; height:75px; width:75px; position:absolute; top:200px; left:710px;"></div>-->		
			</div>
			
			
			
			<!--<div id="secondarytext" style="font: 20px lucida grande; color:black; position:absolute; top:425px; left:550px; width:330px">Use Shoutbound to organize group travel and get travel advice, ideas and recommendations from friends and family!</div>-->
		</div>
		
		<!--main end-->
		
		<div id="footer"><!--footer start-->
			<div id="navbar">
				<ul>
					<li><a href="#">About</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Contact Us</a></li>
				</ul>		
			</div>		
		</div><!--footer end-->


		<script>
		function shoutboundLogin() {
		    $.ajax({url: "<?=site_url('users/ajax_login')?>",
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
		
		$(document).ready(function () {
		    $('#fb_login_button').click(function() {
		        FB.login(function(response) {
		            if(response.session) {
		                shoutboundLogin();
		            } else {
		                alert('you failed to log in');
		            }
		        }, {perms:"email"});
		        return false;
		    });
		});
		</script>

	</body>
</html>