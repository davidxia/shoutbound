<html>
	<head>
		<title>Shoutbound - Login</title>
		<link rel="stylesheet" href="<?= site_url('static/css/signup.css')?>" type="text/css" media="screen" />
		<script type="text/javascript" src="http://dev.shoutbound.com/david/static/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="http://dev.shoutbound.com/david/static/js/jquery/popup.js"></script>
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

  <div id="div-to-popup" style="background-color:white; display:none;"></div>

	<div id="container" style="width:800px; margin:auto; text-align:center;">
	<div id="title" style="margin-top: 40px; line-height:100px; font-size:35px; font-weight:bold;">
    <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" style="height:auto; width:auto; display:inline-block; position: relative; top:12px; margin-right:10px; border:0;" /></a>
    Login to Shoutbound
  </div>
  <div style="margin:10px auto; width:400px; border-top: 1px solid gray; padding-top:20px;">
    <form id="login-form" action="">
      <table><tbody>
        <tr>
          <th><label for="email">Email</label></th>
          <td><input type="text" name="email" id="email" autocomplete="off" size="20"/></td>
        </tr>
        <tr>
          <th><label for="password">Password</label></th>
          <td><input type="password" name="password" id="password" autocomplete="off" /></td>
        </tr>
        <tr>
          <th></th>
          <td style="padding-left:70px;"><input type="submit" id="login-form-submit" value="sign in" /></td>
        </tr>
      </tbody></table>
    </form>
    <br/>
      	<span style="font-size:20px; font-weight: bold; font-size:20px;	color:black;">or</span>
    <div style="text-align:center;">
      <a href="#" id="fb_login_button">
        <img src="<?=site_url('images/fb-login-button.png');?>" />
      </a>
    </div>
    <br/>
  	<div style="margin-top:10px; border-top: 1px solid gray; padding-top:25px;">
      Don't have an account? Sign up <a href="http://dev.shoutbound.com/david/signup">here</a>.
    </div>
  </div>
</div>

</body>
<script type="text/javascript">
  
  
  $(document).ready(function() {
    $('#fb_login_button').click(function() {
      FB.login(function(response) {
        if (response.session) {
          facebookLogin();
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
    
    $('#login-form-submit').click(function() {
      var postData = {
        email: $('#email').val(),
        password: $('#password').val()
      };
      
      $.ajax({
        url: "<?=site_url('login/email_login')?>",
        type: 'POST',
        data: postData,
        success: function(response) {
          var r = $.parseJSON(response);
          if (r.success) {
            window.location = "<?=site_url('/')?>";
          } else {
            $('#div-to-popup').empty();
            var html = 'Wrong email or password. Try again.';
            $('#div-to-popup').append(html);
            $('#div-to-popup').bPopup();  
          }
        }
      });
      return false;
    });
  });


	function facebookLogin() {
    $.ajax({
      url: "<?=site_url('login/ajax_facebook_login')?>",
      success: function(response) {
        var r = $.parseJSON(response);
        if (r.existingUser) {
          updateFBFriends();
        } else {
          showAccountCreationDialog();
        }
      }
    });
	}
	
	
	function updateFBFriends() {
    $.ajax({
      url: "<?=site_url('login/ajax_update_fb_friends')?>",
      success: function() {
        window.location = "<?=site_url('/')?>";
      }
    });
	}
	
	
  function showAccountCreationDialog() {
    $('#div-to-popup').empty();
    var html = 'Creating your Shoutbound account...';
    $('#div-to-popup').append(html);
    $('#div-to-popup').bPopup();  

    $.ajax({
      url: "<?=site_url('signup/ajax_create_fb_user')?>",
      success: function(response) {
        var r = $.parseJSON(response);
        if ( ! r.error) {
          window.location = r.redirect;
        } else {
          alert(r.message);
        }
      }
    });
  }


</script>
</html>
