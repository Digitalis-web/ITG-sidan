<?php

	session_start();
	include "../functions.php";
	
	
	
	// Makes sure the user is logged in
	if(isset($_SESSION['log_in'])) {
		
		// Makes sure that user is admin
		if($_SESSION['log_in'] == 2){
			$con = connect();
			
			if(isset($_POST['info']) && isset($_POST['title'])) {
				$errors = [];
				$change_image = false;
				
				$info = secure_str($_POST['info']);
				$title = secure_str($_POST['title']);
				$page_name = secure_str($_POST['page_name']);
				
				
				if(sizeof($errors) == 0) {
					//$date = secure_str(date("Y-m-d H:i:s"));
					
					$select_page = mysqli_query($con, "SELECT * FROM page_text WHERE page = '$page_name'");
					// checks if this page doesn't exists in the database already, it which case it will be created
					if(mysqli_num_rows($select_page) == 0){
						mysqli_query($con, "INSERT into page_text (page) values ('$page_name')");
					}
					
					
					$query = "UPDATE page_text SET content='$info', title = '$title' WHERE page = '$page_name'";
					$result = mysqli_query($con, $query) or die (mysqli_error($con));
					
					if(!$result) {
						$errors[] = "Failed to connect to database, please try again";
					}
					
				}
				
				
				
				if(sizeof($errors) == 0){ // If the post was sucessfully posted
					echo "true";
					$_SESSION['editor_mode'] = false;
				}
				else
				{
					echo "<h3>Errors: </h3>";
					foreach($errors as $error){
						echo "- ".$error . "<br>";
					}
					
					
				}	
				
				}	
			}
			}
			
				?>																					