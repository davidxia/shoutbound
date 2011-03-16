<?php
$header_args = array(
    'title' => 'Login | Shoutbound',
    'css_paths' => array(
        'css/signup.css',
    ),
    'js_paths' => array(
        'js/jquery/popup.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url('')?>";
  var staticUrl = "<?=static_url('')?>";
</script>
  
</head>

<body style="background-color:#1B272C; min-width:960px;">

  <? $this->load->view('header')?>

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

	<div class="wrapper" style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">
    <div class="content" style="margin:0 auto; padding-top:30px; margin:0 auto; width:400px; padding-bottom:80px;">
      <h2 style="text-align:center; margin:20px 0;">Login here</h2>
      <form id="login-form" action="" style="border:1px solid #AAA; padding:20px;">
        <div>
          <fieldset>
            <ul>
              <li style="margin-bottom:20px;">
                <label for="email" style="display:block; margin-bottom:10px;">Email</label>
                <input type="text" name="email" id="email" autocomplete="off"/>
              </li>
              <li style="margin-bottom:20px;">
                <label for="password" style="display:block; margin-bottom:10px;">Password</label>
                <input type="password" name="password" id="password" autocomplete="off"/>
              </li>
            </ul>
          </fieldset>
        </div>
        <div style="text-align:center;">
          <button type="submit" id="login-button">Login</button>
        </div>
      </form>

      <div style="text-align:center; margin:20px 0 40px;">
      	<div style="font-size:20px; font-weight:bold; margin:10px 0;">or</div>
        <a href="#" id="fb_login_button">
          <img src="<?=site_url('images/fb-login-button.png');?>" />
        </a>
      </div>
      
    	<div style="text-align:center;">
        Don't have an account? <a href="<?=site_url('signup')?>">Sign up</a>.
      </div>
    </div>
  </div>

  <? $this->load->view('footer')?>

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
    
    $('#login-button').click(function() {
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
