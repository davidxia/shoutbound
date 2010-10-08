<html>
<head>
    <title>Noknok - It's in Beta!</title>
</head>

<body>

<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({appId: 'your app id', status: true, cookie: true,
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

<img src="<?=site_url('images/fb-login-button.png');?>" id="fb_login_button"/>

</body>
</html>
