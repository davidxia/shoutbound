<html>
	<head>
		<title>Shoutbound - Sign Up</title>
		<link rel="stylesheet" href="<?= site_url('static/css/signup.css')?>" type="text/css" media="screen" />
	</head>
<body>

    <h1>Create your account</h1>
    <a href="<?=site_url('landing')?>">go back</a>
        <div id="signup_form">
        <?= form_open('signup/create_user')?>
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
</body>
</html>
