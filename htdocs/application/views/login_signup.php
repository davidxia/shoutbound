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

<div style="padding:20px;">
  <div style="width:300px; float:left;">
    <h3>Login</h3>
    <form action="" method="post" style="margin-top:10px;">
      <fieldset style="border:0">
        <ul>
          <li style="margin-bottom:10px;">
            <label for="email" style="display:block; margin-bottom:10px;">Email</label>
            <input type="text" name="email" id="email" autocomplete="off" style="width:250px;"/>
          </li>
          <li style="margin-bottom:10px;">
            <label for="password" style="display:block; margin-bottom:10px;">Password</label>
            <input type="password" name="password" id="password" autocomplete="off" style="width:250px;"/>
            <div id="login-error" style="color:red; margin-top:5px; height:18px; line-height:18px;"></div>
          </li>
        </ul>
      </fieldset>
      <button type="submit" id="login-submit" class="blue-button">Login</button>
    </form>
    <div style="margin-top:20px;">
      <a href="#" id="fb_login_button">
        <img src="<?=site_url('images/fb-login-button.png');?>" width="154" height="22"/>
      </a>
    </div>
  </div>
  
  <div style="width:300px; margin-left:300px;">
    <h3>Sign up</h3>
    <div id="signup-form-container">
    <form id="signup-form" action="" method="post" style="margin-top:10px;">
      <fieldset style="border:0">
        <ul>
          <li style="margin-bottom:10px;">
            <div class="label-and-error" style="margin-bottom:10px;">
              <label for="signup_name">Name</label>
              <span class="error-message" style="float:right;"></span>
            </div>
            <input type="text" name="signup_name" id="signup_name" autocomplete="off"/>
          </li>
          <li style="margin-bottom:10px;">
            <div class="label-and-error" style="margin-bottom:10px;">
              <label for="signup_email">Email</label>
              <span class="error-message" style="float:right;"></span>
            </div>
            <input type="text" name="signup_email" id="signup_email" autocomplete="off"/>
          </li>
          <li style="margin-bottom:10px;">
            <div class="label-and-error" style="margin-bottom:10px;">
              <label for="signup_pw">Password</label>
              <span class="error-message" style="float:right;"></span>
            </div>
            <input type="password" name="signup_pw" id="signup_pw" autocomplete="off"/>
          </li>
        </ul>
      </fieldset>
      <div style="text-align:center;">
        <button type="submit" id="signup-submit">Sign up</button>
      </div>
    </form>
    </div>
  </div>
</div>



<script type="text/javascript">
  // if user signs up thru facebook, call ajax_facebook_login to check
  // if they are existing user, if they are ajax_facebook_login logs them in
  // and submits the trip creation form; if they aren't existing user
  // call ajax_create_fb_user to create their account, check for errors,
  // then submit trip creation form
	function facebookLogin() {
    $.ajax({
      url: '<?=site_url('login/ajax_facebook_login')?>',
      success: function(r) {
        var r = $.parseJSON(r);
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
        $('#trip-creation-form').submit();
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
        if (r.error) {
          alert(r.message);
        } else {
          $('#trip-creation-form').submit();
        }
      }
    });
  }


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

	
  // jquery form validation plugin
  $('#signup-form').validate({
    rules: {
      signup_name: {
        required: true
      },
      signup_email: {
        required: true,
        email: true
      },
      signup_pw: {
        required: true,
        minlength: 3
      }
    },
    messages: {
      signup_name: 'You gotta have a name, man',
      signup_email: {
        required: 'we promise not to spam you',
        email: 'come on, that\'s not an email'
      },
      signup_pw: {
        required: 'no password? you crazy!',
        minlength: 'weak! at least 3 characters'
      }
    }
  });
  
  // use ajax to submit form, get user's id, then create trip
  $('#signup-submit').click(function() {
    if ($('#signup-form').valid()) {
      var postData = {
        name: $('#signup_name').val(),
        email: $('#signup_email').val(),
        password: $('#password_create').val()
      };
      
      $.ajax({
        type: 'POST',
        data: postData,
        url: '<?=site_url('signup/ajax_create_user')?>',
        // once user is created and logged in, submit create trip form
        success: function() {
          loginSignupSuccess();
        }
      });
    }
    return false;
  });
  
  $('#login-submit').click(function() {
    var postData = {
      email: $('#email').val(),
      password: $('#password').val()
    };
    
    $.ajax({
      type: 'POST',
      data: postData,
      url: '<?=site_url('login/ajax_email_login')?>',
      // once user is logged in, submit create trip form
      success: function(r) {
        var r = $.parseJSON(r);
        if (r.loggedin) {
          //$('#trip-creation-form').submit();
          loginSignupSuccess();
        } else {
          $('#login-error').html('Wrong email or password.');
        }
      }
    });
    return false;
  });

</script>