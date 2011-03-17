<?
$header_args = array(
    'title' => 'Sign Up | Shoutbound',
    'css_paths' => array(
        'css/signup.css',
    ),
    'js_paths' => array(
        'js/jquery/validate.min.js',
        'js/jquery/popup.js',
    )
);

$this->load->view('core_header', $header_args);
?>
</head>
	
<body style="background-color:white; min-width:960px;">

  <?=$this->load->view('header')?>

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

	<div class="wrapper" style="background:white">
    <div class="content" style="margin:0 auto; padding-top:30px; margin:0 auto; width:400px; padding-bottom:80px; margin-top: 30px;">
    	<div style="border: 1px solid black; background-color:#FAFAFA;">
	      <h2 style="text-align:center; margin:20px 0;">Create an account</h2>
	      <form id="signup-form" action="<?=site_url('signup/create_user')?>" method="post" style="padding:10px;">
	        <div style="margin-bottom:20px;">
	          <fieldset style="border:0">
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
	                <input type="text" name="email" id="email" autocomplete="off"/>
	              </li>
	              <li style="margin-bottom:20px;">
	                <div class="label-and-error" style="margin-bottom:10px;">
	                  <label for="password">Password</label>
	                  <span class="error-message" style="float:right;"></span>
	                </div>
	                <input type="password" name="password" id="password" autocomplete="off"/>
	              </li>
	            </ul>
	          </fieldset>
	        </div>
       	
	        <div style="text-align:center;">
	          <button id="signup-button" type="submit">Create my account</button>
	        </div>
	      </form>
      
            
	      <div style="text-align:center; margin:20px 0; padding-bottom:20px;">
	      	<div style="font-size:20px; font-weight:bold; margin:10px 0; ">or</div>
	      	<a href="#" id="fb_login_button">
	        	<img src="<?=site_url('images/fb-login-button.png')?>"/>
	      	</a>
	      </div>
      </div>
         
    	<div style="text-align:center; margin-top:15px;">
        Already have an account? <a href="<?=site_url('login')?>">Login</a>.
      </div>
      
    </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  
  <?=$this->load->view('footer')?>
  
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
