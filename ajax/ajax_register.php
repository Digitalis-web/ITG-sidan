<?php
	
	include "../functions.php";
	
	$con = connect();
	$email = secure_str($_POST['email']);
	$fname = secure_str($_POST['fname']);
	$lname = secure_str($_POST['lname']);
	$password = secure_str($_POST['password']);
	$password_repeat = secure_str($_POST['password_repeat']);
	$access_code = secure_str($_POST['access_code']);
	$school_id = secure_str($_POST['school_id']);
	
	$errors = [];
	
	$select_email = mysqli_query($con, "SELECT * FROM account WHERE email = '$email'") or die(mysqli_error($con));
	
	if(mysqli_num_rows($select_email) > 0){
		$errors[] = "There is already an account with this email";
	}
	
	if($password != $password_repeat){
		$errors[] = "The passwords do not match";
	}
	
	
	if(empty($fname) || empty($lname) || empty($email) || empty($password) || empty ($access_code) || empty($password_repeat)){
		$errors[] = "One or more required fields were left empty";
	}
	
	$level = -1;
	
	$select_pass = mysqli_query($con, "SELECT * FROM constant WHERE constant_name = 'admin_password' ");
	$data_pass = mysqli_fetch_array($select_pass);
	$admin_pass = $data_pass['value'];
	
	// checks if the school code that was entered matches the admin password
	if ($access_code === $admin_pass){
		$level = 2;
	}
	
	$select_pass = mysqli_query($con, "SELECT * FROM constant WHERE constant_name = 'teacher_password'");
	$data_pass = mysqli_fetch_array($select_pass);
	$teacher_pass = $data_pass['value'];
	
	// checks if the school code that was entered matches the teacher password
	if ($access_code === $teacher_pass){
		$level = 1;
	}
	
	$select_pass = mysqli_query($con, "SELECT * FROM constant WHERE constant_name = 'student_password'");
	$data_pass = mysqli_fetch_array($select_pass);
	$student_pass = $data_pass['value'];
	
	// checks if the school code that was entered matches the admin password
	if ($access_code=== $student_pass){
		$level = 0;
	}
	
	if($level == -1){
		$errors[] = "You need to enter a correct accses code";
	}
	
	
	
	// If there are no errors so far
	if(sizeof($errors) == 0){
		$password = password_hash($password, PASSWORD_BCRYPT, array(
		'cost' => 12
		));
		$reg_date = date("Y-m-d");
		$query = ("INSERT INTO account (fname, lname, email, password, reg_date, school_id, level) VALUES ('$fname', '$lname', '$email', '$password', '$reg_date', '$school_id', '$level')");
		mysqli_query($con, $query) or die (mysqli_error($con));
	}
	
	
	$message = "";
	
	// if there are no errors
	if(sizeof($errors) == 0){
		echo "true";
	}
	else {
		echo "<strong>Errors: </strong><br>";
		foreach($errors as $error){
			echo "- " . $error . "<br>";
			
		}
	}
	
	
	
	
	
	
?>		