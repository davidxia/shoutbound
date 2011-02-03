<html>
<head>
    <title>ShoutBound</title>
</head>

<body>

<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({appId: '136139119767617', status: true, cookie: true,
                 xfbml: true});
    };
    (function() {
            var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
    }());
</script>

<a href="#" id="fb_login_button">
    <img src="<?=site_url('images/fb-login-button.png');?>" />
</a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"
        type="text/javascript"></script>
        
<script>
function perform_login() {
    $.ajax({
        url: "<?=site_url('user/ajax_login');?>",
        type: "POST",
        dataType: "json",
        success: function(data) {
            if(data['success']) {
                window.location = data['redirect'];
            } else {
                alert(data['message']);
            }
        }
    });
}

$(document).ready(function () {
    $('#fb_login_button').click(function() {
        FB.login(function(response) {
            if(response.session) {
                perform_login();
            } else {
                alert('you failed to log in');
            }
        }, {perms:"offline_access,user_about_me,friends_about_me,user_hometown,friends_hometown,email"});
        return false;
    });
});
</script>

</body>
</html>
