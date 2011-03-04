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
    <div>Sign in</div>
    <form action="" method="post">
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
          <td><input type="submit" value="sign in" id="signin-submit" style="cursor:pointer;" /></td>
        </tr>
      </tbody></table>
    </form>
    <div style="font-size:20px; text-align:center; padding:20px;">OR</div>
    <div style="text-align:center;">
      <a href="#" id="fb_login_button">
        <img src="<?=site_url('images/fb-login-button.png');?>" />
      </a>
    </div>
  </div>
  
  <div style="width:300px; float:left;">
    <h1>Create your account</h1>
    <div id="signup-form-container">
    <form id="signup-form" action="" method="post">
      <fieldset>
        <table><tbody>
          <tr>
            <th><label for="name">Full name</label></th>
            <td><input type="text" name="signup_name" id="signup_name" class="required" autocomplete="off" size="20"/></td>
          </tr>
          <tr>
            <th><label for="email">Email</label></th>
            <td><input type="text" name="signup_email" id="signup_email" autocomplete="off" /></td>
          </tr>
          <tr>
            <th><label for="password">Password</label></th>
            <td><input type="password" name="password_create" id="password_create" autocomplete="off" /></td>
          </tr>
          <tr>
            <th><label for="password_confirm">Confirm password</label></th>
            <td><input type="password" name="password_confirm" id="password_confirm" autocomplete="off" /></td>
          </tr>
          <tr>
            <th></th>
            <td><input type="submit" name="submit" id="signup-submit" value="Create account" style="cursor:pointer;"</td>
          </tr>
        </tbody></table>
      </fieldset>
    </form>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $('#fb_login_button').click(function() {
      FB.login(function(response) {
        if (response.session) {
          shoutboundLogin();
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
  });

  // if user signs up thru facebook, call ajax_login to check
  // if they are existing user, if they are ajax_login logs them in
  // and submits the trip creation form; if they aren't existing user
  // call ajax_create_user to create their account, check for errors,
  // then submit trip creation form
	function shoutboundLogin() {
    $.ajax({
      url: "<?=site_url('users/ajax_login')?>",
      type: 'POST',
      dataType: 'json',
      success: function(response) {
        if (response['existingUser']) {
          $('#trip-creation-form').submit();
        } else if (response['existingUser'] == false) {
          $.ajax({
            url: baseUrl+'users/ajax_create_user',
            type: 'POST',
            dataType: "json",
            success: function(response) {
              if (response['error']) {
                alert(response['message']);
              } else {
                $('#trip-creation-form').submit();
              }
            }
          });
        }
      }
    });
	}
	
	
  // jquery form validation plugin
  $('#signup-form').validate({
    rules: {
      signup_email: {
        required: true,
        email: true
      },
      password_create: {
        required: true,
        minlength: 3
      },
      password_confirm: {
        required: true,
        equalTo: "#password_create"
      }
    },
    messages: {
      signup_name: 'You gotta have a name, man',
      signup_email: {
        required: 'we promise not to spam you',
        email: 'come on, that\'s not an email'
      },
      password_create: {
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
        url: baseUrl+'signup/ajax_create_user',
        // once user is created and logged in, submit create trip form
        success: function() {
          $('#trip-creation-form').submit();
        }
      });
    }
    return false;
  });
  
  $('#signin-submit').click(function() {
    var postData = {
      email: $('#email').val(),
      password: $('#password').val()
    };
    
    $.ajax({
      type: 'POST',
      data: postData,
      url: baseUrl+'users/ajax_email_login',
      // once user is logged in, submit create trip form
      success: function(response) {
        var r = $.parseJSON(response);
        if (r.loggedin) {
          $('#trip-creation-form').submit();
        } else {
          alert('invalid email or password');
        }
      }
    });
    return false;
  });

</script>