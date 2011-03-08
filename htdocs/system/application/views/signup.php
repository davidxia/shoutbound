<html>
	<head>
		<title>Shoutbound - Sign Up</title>
		<link rel="stylesheet" href="<?= site_url('static/css/signup.css')?>" type="text/css" media="screen" />
		<script type="text/javascript" src="http://dev.shoutbound.com/david/static/js/jquery/jquery.js"></script>
	</head>
<body style="background:url('<?=site_url('images/trip_page_background.png')?>'); background-repeat:repeat-x;">
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

	<div id="container" style="width:800px; margin:auto; text-align:center;">
	<div id="title" style="margin-top: 40px; line-height:100px; font-size:35px; font-weight:bold;  border-bottom: 1 px solid gray;">
    <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" style="height:auto; width:auto; display:inline-block; position: relative; top:12px; margin-right:10px; border:0;" /></a>
    Sign-up for Shoutbound!
  </div>  
        <div id="signup_form"><h2 style="margin-left:130px;">Create an account</h2>
        <?=form_open('signup/create_user')?>
        <fieldset style="border:0">
        <table><tbody>
            <tr>
                <th><label for="name">Name</label></th>
                <td><input type="text" name="name" id="name" autocomplete="off" size="20"/></td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td><input type="text" name="email" id="email" autocomplete="off" /></td>
            </tr>
            <tr>
                <th><label for="password">Password</label></th>
                <td><input type="password" name="password" id="password" autocomplete="off" /></td>
            </tr>
            <tr>
                <th><label for="password_confirm">Confirm password</label></th>
                <td><input type="password" name="password_confirm" id="password_confirm" autocomplete="off" /></td>
            </tr>
            <tr>
                <th></th>
                <td><?= form_submit('submit', 'Create Acccount') ?></td>
            </tr>

        </tbody></table>
        
                
        <?= validation_errors('<p class="error">') ?>
        </fieldset>
        </div>
      <div style="text-align:center; display:inline-block;">
      	<span style="font-size:20px; font-weight: bold; font-size:20px;	color:black;">or</span>
      	<a href="#" id="fb_login_button" style="margin-left:5px; position: relative; top:3px;">
        	<img src="<?=site_url('images/fb-login-button.png');?>" />
      	</a>
      </div>
        <div style="margin-top:10px; border-top: 1px solid gray; padding-top:25px;">Already have an account?  Log-in <a href="http://dev.shoutbound.com/david/login">here</a>.</div>
        
</div>
</body>
<script type="text/javascript">
  $(document).ready(function() {
    $('#fb_login_button').click(function() {
      FB.login(function(response) {
        if (response.session) {
          shoutboundLogin();
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
  });

	function shoutboundLogin() {
    $.ajax({
      url: "<?=site_url('users/ajax_facebook_login')?>",
      type: 'POST',
      dataType: 'json',
      success: function(data) {
        if (data['success']) {
          window.location = data['redirect'];
        } else {
          alert(data['message']);
        }
      }
    });
	}

</script>
</html>
