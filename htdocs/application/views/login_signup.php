<!-- <div id="fb-root"></div> -->
<script>
/*
  window.fbAsyncInit = function() {
      FB.init({appId: '136139119767617', status: true, cookie: true, xfbml: true});
  };
  (function() {
      var e = document.createElement('script'); e.async = true;
      e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
      document.getElementById('fb-root').appendChild(e);
  }());
*/
</script>

<!-- POPUP CONTAINER -->
<div style="padding:20px; background-color:white; border-radius: 5px; -webkit-border-radius:5px; -moz-border-radius:5px; border:8px solid #666; width:415px; height:120px;">

  <!-- LOGIN CONTAINER -->
  <div style="width:200px; float:right;">
    <div style="font-size:15px; font-weight:bold; margin-bottom:15px;">Login</div>
    <form action="" method="post">
      <fieldset style="border:0">      
        <div style="margin-bottom:5px">
          <input type="text" name="email" id="email" autocomplete="off" style="width:125px; float:right;"/>
          <label for="email" style="display:inline;">Email</label>
          <div style="clear:both"></div>
        </div>        
        <div style="margin-bottom:5px">       
          <input type="password" name="password" id="password" autocomplete="off" style="width:125px; float:right;"/>
          <label for="password" style="display:inline;">Password</label>
          <div style="clear:both"></div>
        </div>              
        <div id="login-error" style="color:red; margin-top:5px; height:18px; line-height:18px;"></div>
      </fieldset>
      <button type="submit" id="login-submit" style="position:relative; left:140px; top:-15px;">Login</button>
    </form>
  <!--
    <a href="#" id="fb_login_button">
      <img src="<?=site_url('static/images/fb-login-button.png');?>" width="154" height="22"/>
    </a>
  -->
  </div><!-- LOGIN CONTAINER ENDS -->

  <!--SIGNUP CONTAINER-->
  <div style="width:175px;border-right:1px dotted #CACACA; padding-right:15px;height:120px;">
    <div style="font-size:15px; font-weight:bold; margin-bottom:15px; ">Don't have an account?</div> 
    <a href="<?=site_url('signup/index')?>">Sign up</a> 
  </div><!--SIGNUP CONTAINER ENDS-->

  <div style="clear:both"></div>  
</div><!--POPUP CONTAINER ENDS-->
  
    
  
<!-- OLD SIGNUP CONTAINER -->
<!--
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
    </div>
--><!-- SIGNUP CONTAINER ENDS -->

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
  
  
/*
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
    $.get('<?=site_url('signup/ajax_get_fb_info')?>', function(d) {
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
*/
  }
</script>