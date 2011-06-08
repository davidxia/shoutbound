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
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
</script>
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
        <div class="step-header">1. Find your friends:</div>
        <div class="step-content">
        	<a href="#" id="fb_login_button">
          	<img src="<?=site_url('static/images/facebook-connect-button.png')?>" height="23" width="180"/>
        	</a>
        	<div id="fb-tip">This helps us connect you to the most relevant people and  content. We'll never post without your permission.</div>
        	<a href="#" id="skip-fb-login">I don't have a Facebook account.</a>
        </div>     
      </div><!--STEP ONE END-->
  	
      <div id="step-two-container" class="step-container"><!--STEP TWO-->
        <div class="step-header">2. Complete your sign-up:</div>
        <div class="step-content">
          <form id="signup-form" action="" method="post">
            <fieldset>         
              <div class="signup-input-container">
                <label for="signup_name" style="color:#555; margin-right:12px;">Full name</label>
                <input type="text" name="signup_name" id="signup_name" class="signup-input" autocomplete="off" <? if(isset($signup_name)){echo 'val="'.$signup_name.'"';}?>/>                
                <span class="error-message" style=""></span>
              </div>
              <div class="signup-input-container">
                <label for="signup_email" style="color:#555; margin-right:31px;">E-mail</label>
                <input type="text" name="signup_email" id="signup_email" class="signup-input" autocomplete="off" <? if(isset($signup_email)){echo 'val="'.$signup_email.'"';}?>/>              
                <span class="error-message"></span>
              </div>
              <div class="signup-input-container">
                <label for="signup_pw" style="color:#555; margin-right:10px;">Password</label>
                <input type="password" name="signup_pw" id="signup_pw" class="signup-input" autocomplete="off" <? if(isset($signup_pw)){echo 'val="'.$signup_pw.'"';}?>/>              
                <span class="error-message"></span>
              </div>
              <div class="signup-input-container">
                <label for="invite_code" style="color:#555; margin-right:4px;">Invite code</label>
                <input type="text" name="invite_code" id="invite_code" class="invite-input" autocomplete="off"/>              
                <span class="error-message"></span>
              </div>
              <input type="hidden" name="is_fb_signup" id="is_fb_signup"/>              
            </fieldset>
            <button type="submit" id="signup-submit">Create Account</button>
          </form>
        </div>   
      </div><!--STEP TWO END-->
  	
  	</div><!--SIGN UP CONTAINER END-->
	  
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
  
</body>

<script type="text/javascript">
  $(function() {
    $('#name').focus();
  
    $('#fb_login_button').click(function() {
      FB.login(function(d) {
        if (d.session) {
          facebookLogin();
        }
      }, {perms: 'email'});
      return false;
    });
    
    $('#skip-fb-login').click(function() {
      $('#step-two-container').show();
      return false;
    });


    $('#signup-form').validate({
      rules: {
        signup_name: 'required',
        signup_email: {
          required: true,
          email: true
        },
        signup_pw: {
          required: true,
          minlength: 4
        }
      },
      messages: {
        signup_name: 'Hi! What\'s your name?',
        signup_email: {
          required: 'We promise not to spam you : )',
          email: 'Oops, was there a typo?'
        },
        signup_pw: {
          required: 'Passwords are your friend.',
          minlength: 'Passwords should be at least 4 characters.'
        }
      },
      errorPlacement: function(error, ele) {
        error.appendTo(ele.siblings('.error-message'));
      }
    });
    
    
    $('#signup-submit').click(function() {
      if ($('#signup-form').valid()) {
        $.post(baseUrl+'signup/create_user',
          {signup_name:$('#signup_name').val(),
           signup_email:$('#signup_email').val(),
           signup_pw:$('#signup_pw').val(),
           invite_code:$('#invite_code').val()},
          function(d) {
            var r = $.parseJSON(d);
            if (r.success && r.inviteCode) {
              window.location = r.redirect;
            } else {
              alert(r.message);
            }
          });
      }
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
      if (r.success) {
        $('#signup_name').val(r.name);
        $('#signup_email').val(r.email);
        $('#is_fb_signup').val(1);
        $('#step-one-container').hide();
        $('#step-two-container').show();
      } else {
        alert(r.message);
      }
    });
  }


  function toggle_visibility(id) {
     var e = document.getElementById(id);
     if(e.style.display == 'block')
        e.style.display = 'none';
     else
        e.style.display = 'block';
  }
</script>
</html>