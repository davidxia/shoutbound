<html>
<head>
<title>Creating your ShoutBound profile...</title>
</head>

<body>
<span id="status">Creating your account...</span>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $.ajax({
        url: "<?=site_url('users/ajax_create_user')?>",
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
});

</script>
</body>
</html>
