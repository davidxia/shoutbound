<?php
$header_args = array(
    'title' => 'Login | Shoutbound',
    'css_paths' => array(
    ),
    'js_paths' => array(
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
  <? $this->load->view('header')?>
  <? $this->load->view('wrapper_content')?>
  
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

    	<div style="border:1px solid black; background-color:#FAFAFA; margin:0 auto; padding:20px; width:400px; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;">
	      <h2>Login</h2>
	      <form id="login-form" action="" style="margin:20px 0;">
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
	                <div id="login-error" style="color:red; margin-top:5px; height:18px; line-height:18px;"></div>
	              </li>
	            </ul>
	          </fieldset>
	        </div>
          <button type="submit" id="login-submit" class="blue-button">Login</button>
	      </form>

        <a href="#" id="fb_login_button">
          <img src="<?=site_url('images/fb-login-button.png');?>" />
        </a>
      </div>
    
    <div style="text-align:center; margin-top:15px;">
       Don't have an account? <a href="<?=site_url('signup')?>">Sign up</a>.
    </div>
    </div>
    </div>
  

  <? $this->load->view('footer')?>

</body>
<script type="text/javascript">
  $(document).ready(function() {
    $('#email').focus();
    
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
    
    $('#login-submit').click(function() {
      var postData = {
        email: $('#email').val(),
        password: $('#password').val()
      };
      
      $.ajax({
        url: '<?=site_url('login/email_login')?>',
        type: 'POST',
        data: postData,
        success: function(response) {
          var r = $.parseJSON(response);
          if (r.success) {
            window.location = "<?=site_url()?>";
          } else {
            var text = 'Wrong email or password.';
            $('#login-error').html(text);
          }
        }
      });
      return false;
    });
  });


	function facebookLogin() {
    $.ajax({
      url: '<?=site_url('login/ajax_facebook_login')?>',
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
      url: '<?=site_url('login/ajax_update_fb_friends')?>',
      success: function() {
        window.location = '<?=site_url('/')?>';
      }
    });
	}
	
	
  function showAccountCreationDialog() {
    $('#div-to-popup').empty();
    var html = 'Creating your Shoutbound account...';
    $('#div-to-popup').append(html);
    $('#div-to-popup').bPopup();  

    $.ajax({
      url: '<?=site_url('signup/ajax_create_fb_user')?>',
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