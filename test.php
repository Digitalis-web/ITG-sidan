<?php
	$password = password_hash("s938hPljS", PASSWORD_BCRYPT, array(
	'cost' => 12
	));
	echo $password;
	
?>