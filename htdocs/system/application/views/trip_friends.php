<h3>Invited Friends</h3>

<?php


//print_r($invited_uids);

//foreach($invited_uids as &$v) {
//	echo "$v\n";
//}


foreach($invited_users as &$invited_user) {
	echo $invited_user['name'];
	?>
	<br>

<?php
	
}



?>