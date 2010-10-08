<html>
<head>
    <title>Noknok - It's in Beta!</title>
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

<h1>LANDING</h1>

<a href="#" id="fb_login_button"><img src="<?=site_url('images/fb-login-button.png');?>" /></a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $('#fb_login_button').click(function() {
        FB.login(function(response) {
            if(response.session) {
                window.location = "<?=site_url('landing/logged_in');?>";
            } else {
                alert('you failed to log in');
            }
        });
        return false;
    });
});
</script>

</body>
</html>
