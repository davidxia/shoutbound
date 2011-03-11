<?
$header_args = array(
    'css_paths'=>array(
        'css/signup.css',
    ),
    'js_paths'=>array(
        'js/jquery/validate.min.js',
        'js/jquery/popup.js',
    )
);

$this->load->view('core_header', $header_args);
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = "<?=site_url("")?>";
  var staticUrl = "<?=static_url("")?>";
</script>


</head>
	
<body style="background:white url('<?=site_url('images/trip_page_background.png')?>') repeat-x 0 0;">

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

	<div id="container" style="width:800px; margin:auto; text-align:center;">
  	<div id="title" style="margin-top: 40px; line-height:100px; font-size:35px; font-weight:bold;  border-bottom: 1 px solid gray;">
      <a href="<?=site_url('/')?>"><img src="<?=site_url('images/logo_header.png')?>" style="height:auto; width:auto; display:inline-block; position: relative; top:12px; margin-right:10px; border:0;" /></a>
      Sign up for Shoutbound
    </div>
    
    <div>
      <h2 style="margin-left:130px;">Create an account</h2>
      <form id="signup-form" action="<?=site_url('signup/create_user')?>" method="post">
      <fieldset style="border:0">
      <table><tbody>
        <tr>
          <th><label for="name">Name</label></th>
          <td><input type="text" name="name" id="name" autocomplete="off" size="20"/></td>
          <td class="error" style="vertical-align:middle;"><div class="error-message" style="width:200px;"></div></td>
        </tr>
        <tr>
          <th><label for="email">Email</label></th>
          <td><input type="text" name="email" id="email" autocomplete="off"/></td>
          <td class="error" style="vertical-align:middle;"><div class="error-message" style="width:200px;"></div></td>
        </tr>
        <tr>
          <th><label for="password">Password</label></th>
          <td><input type="password" name="password" id="password" autocomplete="off"/></td>
          <td class="error" style="vertical-align:middle;"><div class="error-message" style="width:200px;"></div></td>
        </tr>
        <tr>
          <th><label for="password_confirm">Confirm password</label></th>
          <td><input type="password" name="password_confirm" id="password_confirm" autocomplete="off" /></td>
          <td class="error" style="vertical-align:middle;"><div class="error-message" style="width:200px;"></div></td>
        </tr>
        <tr>
          <th></th>
          <td><input class="submit" type="submit" value="Create my account"/></td>
          <td></td>
        </tr>
      </tbody></table>
      </fieldset>
    </div>
    
    <div style="text-align:center; display:inline-block;">
    	<span style="font-size:20px; font-weight: bold; font-size:20px;	color:black;">or</span>
    	<a href="#" id="fb_login_button" style="margin-left:5px; position: relative; top:3px;">
      	<img src="<?=site_url('images/fb-login-button.png');?>" />
    	</a>
    </div>
      
    <div style="margin-top:10px; border-top: 1px solid gray; padding-top:25px;">
      Already have an account? Login
      <a href="http://dev.shoutbound.com/david/login">here</a>.
    </div>
        
  </div>
  
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
      url: baseUrl+'login/ajax_facebook_login',
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
      url: baseUrl+'login/ajax_update_fb_friends',
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
      url: baseUrl+'signup/ajax_create_fb_user',
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
      },
      password_confirm: {
        equalTo: '#password'
      }
    },
    messages: {
      name: 'You gotta have a name, yo.',
      email: {
        required: 'We promise not to spam you.',
        email: 'Nice try, enter a valid email.'
      },
      password: {
        required: 'Password protect that shit.',
        minlength: 'make it at least 4 characters'
      },
      password_confirm: {
        equalTo: 'Reenter your password.'
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo(element.parent().siblings('.error').children('.error-message'));
    }
  });


</script>
</html>
