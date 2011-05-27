<?
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
    'css_paths' => array(
      'css/signup.css',
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
		
  	<div id="signup-container"><!--SIGN UP CONTAINER-->
      <div id="signup-title">Join Shoutbound.</div>
      
      <div id="step-one-container" class="step-container"><!--STEP ONE-->
        <div class="step-header">1. Find your friends.</div>
        <div class="step-content">
        	<a href="#" id="fb_login_button">
          	<img src="<?=site_url('static/images/fb-login-button.png')?>"/>
        	</a>
          <input type="hidden" name="is_fb_signup" id="is_fb_signup"/>
        	<div id="fb-tip">This helps us connect you the most relevant travel content. We'll never post without your permission.</div>
        	<a href="#" id="skip-step-one">I don't have a Facebook account.</a>
        </div>     
      </div><!--STEP ONE END-->
  	
      <div id="step-two-container" class="step-container"><!--STEP TWO-->
        <div class="step-header">2. Complete your profile.</div>
        <div class="step-content">
          <form id="signup-form" action="<?=site_url('signup/create_user')?>" method="post">
            <fieldset>    
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="name">Name</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="name" id="name" autocomplete="off"/>
              
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="email">Email</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="email" id="email" autocomplete="off"/>
              
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="password">Password</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="password" name="password" id="password" autocomplete="off"/>
            </fieldset>
            <button type="submit" id="signup-submit">Create Account</button>
          </form>
        </div>   
      </div><!--STEP TWO END-->
  	
  	</div><!--SIGN UP CONTAINER END-->
	  
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
    $.get('<?=site_url('signup/ajax_create_fb_user')?>', function(d) {
      var r = $.parseJSON(d);
      if (r.success) {
        $('#name').val(r.name);
        $('#email').val(r.email);
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
      name: 'We need to know your name!',
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