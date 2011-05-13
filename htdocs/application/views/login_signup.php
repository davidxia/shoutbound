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

<!-- POPUP CONTAINER -->
<div style="padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 8px; -webkit-border-radius:8px; -moz-border-radius:8px;">
  <div style="background-color:#FAFAFA;padding:10px 10px 10px 10px;">
  
    <!-- LOGIN CONTAINER -->
    <div style="width:300px; float:right;">
      <h3>Login</h3>
      <form action="" method="post" style="margin:10px 0 20px;">
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
      <a href="#" id="fb_login_button">
        <img src="<?=site_url('static/images/fb-login-button.png');?>" width="154" height="22"/>
      </a>
    </div><!-- LOGIN CONTAINER ENDS -->
  
  
    <!-- SIGNUP CONTAINER -->
    <div style="width:300px; margin-right:300px;">
      <h3>Sign up</h3>
      <div id="signup-form-container" style="margin-right:40px;">
      <form id="signup-form" action="" method="post" style="margin-top:10px;">
        <fieldset style="border:0">
          <ul>
            <li style="margin-bottom:10px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="signup_name">Name</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="signup_name" id="signup_name" autocomplete="off" style="width:250px;"/>
            </li>
            <li style="margin-bottom:10px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="signup_email">Email</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="text" name="signup_email" id="signup_email" autocomplete="off" style="width:250px;"/>
            </li>
            <li style="margin-bottom:10px;">
              <div class="label-and-error" style="margin-bottom:10px;">
                <label for="signup_pw">Password</label>
                <span class="error-message" style="float:right;"></span>
              </div>
              <input type="password" name="signup_pw" id="signup_pw" autocomplete="off" style="width:250px;"/>
            </li>
          </ul>
        </fieldset>
        <button type="submit" id="signup-submit" class="blue-button">Sign up</button>
      </form>
      </div>
    </div><!-- SIGNUP CONTAINER ENDS -->
  </div>
</div><!-- POPUP CONTAINER ENDS -->



<script type="text/javascript">
  $(function() {
    $.getScript(baseUrl+'static/js/jquery/validate.min.js', function() {
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
        },
        errorPlacement: function(error, element) {
          error.appendTo(element.siblings('.label-and-error').children('.error-message'));
        }
      });
    });
    

    $('#login-submit').click(function() {    
      $.post('<?=site_url('login/ajax_email_login')?>', {email:$('#email').val(), password:$('#password').val()},
        function(d) {
          var r = $.parseJSON(d);
          if (r.loggedin) {
            loginSignup.success('<?=$callback?>', '<?=$id?>', '<?=$param?>');
          } else {
            $('#login-error').html('Wrong email or password.');
          }
        });
      return false;
    });
    
  
    $('#signup-submit').click(function() {
      if ($('#signup-form').valid()) {
        $.post('<?=site_url('signup/ajax_create_user')?>', {signupName:$('#signup_name').val(), signupEmail:$('#signup_email').val(),signupPw:$('#signup_pw').val()},
          function() {
            loginSignup.success('<?=$callback?>', '<?=$id?>', '<?=$param?>');
          });
      }
      return false;
    });
  
  
    $('#fb_login_button').click(function() {
      FB.login(function(r) {
        if (r.session) {
          facebookLogin('<?=$callback?>', '<?=$id?>', '<?=$param?>');
        } else {
          alert('you failed to log in');
        }
      }, {perms: 'email'});
      return false;
    });
  });
  
  
	function facebookLogin(callback) {
    $.get('<?=site_url('login/ajax_facebook_login')?>', function(d) {
      var r = $.parseJSON(d);
      if (r.existingUser) {
        updateFBFriends(callback);
      } else {
        showAccountCreationDialog();
      }
    });
	}
	
	
	function updateFBFriends(callback) {
    $.get('<?=site_url('login/ajax_update_fb_friends')?>', function() {
      loginSignup.success(callback);
    });
	}
	

  function showAccountCreationDialog() {
    $.get('<?=site_url('signup/ajax_create_fb_user')?>', function(d) {
      var r = $.parseJSON(d);
      if (r.success) {
        $('#signup_name').val(r.name);
        $('#signup_email').val(r.email);
        $('#is_fb_signup').val(1);
        $('#fb_login_button').hide();
      } else {
        alert(r.message);
      }
    });
  }
</script>