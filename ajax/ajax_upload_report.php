<?php
	session_start();
	include "../functions.php";
	$con = connect();
	
	if($_SESSION['log_in'] > 0){
		
		$errors = [];
		
		//checks if this image exists in the form
		if(isset($_FILES['report'])){						
			
			$file = $_FILES['report']['tmp_name'];
			// makes sure that the input isn't empty
			if($file) {
				$report = mysqli_real_escape_string($con, file_get_contents($_FILES['report']['tmp_name']));
				$report_name = mysqli_real_escape_string($con, $_FILES['report']['name']);	
				
			}
			else{
				$errors[] = "The file seems to be empty. Please try again";
			}
			
			$mime = generate_report_mime($report_name);
			
			if(!$mime){
				$errors[] = "This format is not supported";
			}
			
			
			
		}
		else {
			$errors[] = "Please try again";
		}
		
		
		if(sizeof($errors) == 0) {
			$date = date("Y-m-d H:i:s");
			$result = mysqli_query($con, "INSERT INTO report (report_file,report_name, date, mime) VALUES ('$report', '$report_name', '$date', '$mime')") or die(mysqli_error($con));
			
			if(!$result){
				$errors[] = "There was an error uploading the file to the database. Please try again later";		
			}
		}
		
		if(sizeof($errors) == 0) {
			echo "true";
		}
		else{
			echo "<h2> Errors:</h2>";
			foreach ($errors as $error){
			echo "-" .$error . "<br>";
		}			
		}
	}
	else {
		echo "You do not have permission to do this";
	}
	
?>		