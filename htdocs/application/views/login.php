<?php
$header_args = array(
    'title' => 'Login | Shoutbound',
    'css_paths' => array(
      'css/login.css',
    ),
    'js_paths' => array(
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
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

    	<div>
        Login
	      <form id="login-form" action="">
	        <div>
	          <fieldset>
	            <ul>
	              <li>
	                <label for="email" style="display:block; margin-bottom:10px;">Email</label>
	                <input type="text" name="email" id="email"/>
	              </li>
	              <li>
	                <label for="password">Password</label>
	                <input type="password" name="password" id="password"/>
	                <div id="login-error"></div>
	              </li>
	            </ul>
	          </fieldset>
	        </div>
          <button type="submit" id="login-submit" class="blue-button">Login</button>
	      </form>

      </div>
    
    <div>
       Don't have an account? <a href="<?=site_url('signup')?>">Sign up</a>.
    </div>

  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  <? $this->load->view('templates/footer')?>
</body>
<script type="text/javascript">
  $(function() {
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
      
      $.ajax('<?=site_url('login/ajax_email_login')?>', postData,
        function(d) {
          var r = $.parseJSON(d);
          if (r.success) {
            window.location = "<?=site_url()?>";
          } else {
            var text = 'Wrong email or password.';
            $('#login-error').html(text);
          }
        });
      return false;
    });
  });


	function facebookLogin() {
    $.get('<?=site_url('login/ajax_facebook_login')?>',function(d) {
      var r = $.parseJSON(d);
      if (r.existingUser) {
        updateFBFriends();
      } else {
        showAccountCreationDialog();
      }
    });
	}
	
	
	function updateFBFriends() {
    $.get('<?=site_url('login/ajax_update_fb_friends')?>', function() {
        window.location = '<?=site_url('/')?>';
    });
	}
	
		
  function showAccountCreationDialog() {
    $.get('<?=site_url('signup/ajax_get_fb_info')?>', function(d) {
      var r = $.parseJSON(d);
      if (!r.error) {
        window.location = r.redirect;
      } else {
        alert(r.message);
      }
    });
  }


</script>
</html>