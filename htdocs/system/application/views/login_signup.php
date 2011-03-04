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
    <form action="<?=site_url('users/login')?>" method="post">
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
          <td><input type="submit" value="sign in" /></td>
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
    <div id="signup_form">
    <?=form_open('signup/create_user')?>
    <fieldset>
    <table><tbody>
        <tr>
            <th><label for="name">Full name</label></th>
            <td><input type="text" name="name" id="name" autocomplete="off" size="20"/></td>
        </tr>
        <tr>
            <th><label for="email">Email</label></th>
            <td><input type="text" name="email" id="email" autocomplete="off" /></td>
        </tr>
        <tr>
            <th><label for="password">Password</label></th>
            <td><input type="password" name="password" id="password" autocomplete="off" /></td>
        </tr>
        <tr>
            <th><label for="password_confirm">Confirm password</label></th>
            <td><input type="password" name="password_confirm" id="password_confirm" autocomplete="off" /></td>
        </tr>
        <tr>
            <th></th>
            <td><?= form_submit('submit', 'Create Acccount') ?></td>
        </tr>
    
    </tbody></table>
    <?= validation_errors('<p class="error">') ?>
    </fieldset>
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

	function shoutboundLogin() {
    $.ajax({
      url: "<?=site_url('users/ajax_login')?>",
      type: 'POST',
      dataType: 'json',
      success: function(data) {
        if (data['success']) {
          window.location = data['redirect'];
        } else {
          alert(data['message']);
        }
      }
    });
	}
</script>