<?php
	
	session_start();
	
	// if you are admin
	if($_SESSION['log_in'] == 2)
	{
		$_SESSION['editor_mode'] = !$_SESSION['editor_mode'];
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	
?>