<?
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
    'css_paths' => array(
    ),
    'js_paths' => array(
        'js/jquery/validate.min.js',
    )
);

$this->load->view('core_header', $header_args);
?>
</head>
	
<body>
  <div id="sticky-footer-wrapper">
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

	<div style="border:1px solid black; background-color:#FAFAFA; margin:0 auto; padding:20px; width:400px; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;">
    <h2>Sign up</h2>
    
    <form id="signup-form" action="<?=site_url('signup/create_user')?>" method="post" style="margin:20px 0;">
      <div style="margin-bottom:20px;">
        <fieldset>
          <ul>
            <li style="margin-bottom:20px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="name">Name</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="name" id="name" autocomplete="off"/>
            </li>
            <li style="margin-bottom:20px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="email">Email</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="signup_email" id="signup_email" autocomplete="off"/>
            </li>
            <li style="margin-bottom:20px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="password">Password</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="password" name="password" id="password" autocomplete="off"/>
            </li>
          </ul>
          <input type="hidden" name="is_fb_signup" id="is_fb_signup"/>
        </fieldset>
      </div>
      <button type="submit" id="signup-submit" class="blue-button">Create my account</button>
    </form>
  
    
  	<a href="#" id="fb_login_button">
    	<img src="<?=site_url('static/images/fb-login-button.png')?>"/>
  	</a>
  	<span id="fb-tip">By connecting with Facebook, we'll help you find your friends who are already using Shoutbound.</span>
  </div>
      
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('footer')?>
</body>
<script type="text/javascript">
  $(function() {
    $('#name').focus();
  
    $('#fb_login_button').click(function() {
      FB.login(function(d) {
        if (d.session) {
          facebookLogin();
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
  });
  

	function facebookLogin() {
    $.get('<?=site_url('login/ajax_facebook_login')?>',function(d) {
      var r = $.parseJSON(d);
      if (r.existingUser) {
        updateFBFriends();
      } else {
        getFBInfo();
      }
    });
	}


	function updateFBFriends() {
    $.get('<?=site_url('login/ajax_update_fb_friends')?>', function() {
        window.location = '<?=site_url('/')?>';
    });
	}
	
		
  function getFBInfo() {
    $.get('<?=site_url('signup/ajax_get_fb_info')?>', function(d) {
      var r = $.parseJSON(d);
      if (r.success) {
        $('#name').val(r.name);
        $('#signup_email').val(r.email);
        $('#is_fb_signup').val(1);
        $('#fb_login_button').hide();
        $('#fb-tip').hide();
      } else {
        alert(r.message);
      }
    });
  }
  
  
  // jquery form validation plugin
  $('#signup-form').validate({
    rules: {
      name: 'required',
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 4
      }
    },
    messages: {
      name: 'You gotta have a name, yo.',
      email: {
        required: 'We promise not to spam you.',
        email: 'Nice try, enter a valid email.'
      },
      password: {
        required: 'Passwords are your friend.',
        minlength: 'make it at least 4 characters'
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo(element.siblings('.label-and-error').children('.error-message'));
    }
  });
</script>
</html>