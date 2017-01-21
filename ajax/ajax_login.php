<?php
	session_start();
	
	include "../functions.php";
	
	
	
	
	$con = connect();
	$email = secure_str($_POST['email']);
	$password = secure_str($_POST['password']);
	
	
	$errors = [];
	
	$query = ("SELECT * FROM account WHERE email = '$email'");
	
	$account_select = mysqli_query($con, $query) or die (mysqli_error($con));
	
	// Check if the query returns any rows. If it doesn't return any rows then it means that there are no accounts with that email adress
	if(mysqli_num_rows($account_select) > 0){
		$account_data = mysqli_fetch_array($account_select);
		
		//if($account_data['password'] == $password){ // Check if the passwords match
		if(password_verify($password, $account_data['password'])){ // Check if the passwords match
			$_SESSION['log_in'] = $account_data['level'];
			
			$_SESSION['fname'] = $account_data['fname'];
			$_SESSION['lname'] = $account_data['lname'];
			$_SESSION['account_id'] = $account_data['account_id'];
			$_SESSION['editor_mode'] = false;
		}
		else {
			$errors[]= "Wrong password";
		}
	}
	else{
		$errors[]= "Wrong password";	
	}
	
	// if there are no errors
	if(sizeof($errors) == 0){
		echo 'true';
	}
	else {
		echo 'false';
	}
	
	
	
?>