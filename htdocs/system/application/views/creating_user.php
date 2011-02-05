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
        url: "<?php echo site_url('user/ajax_create_user'); ?>",
        type: "POST",
        dataType: "json",
        error: function(data) {
            alert('Major problem occured! Call up Ben quick!');
        },
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
