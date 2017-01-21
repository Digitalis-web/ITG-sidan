<?php
	session_start();
	
	include "../functions.php";
	
	
	// Makes sure the user is logged in
	if(isset($_SESSION['log_in'])) {
		
		// Makes sure that user is admin
		if($_SESSION['log_in'] == 2){
			$con = connect();
			
			if(isset($_POST['name']) && isset($_POST['info'])) {
				$errors = [];
				$change_image = false;
				
				$info = secure_str($_POST['info']);
				$name = secure_str($_POST['name']);
				$school_id = secure_str($_POST['school_id']);
				
				
				//checks if this image exists in the form
				if(isset($_FILES['school_image'])){						
					
					$file = $_FILES['school_image']['tmp_name'];
					
					// makes sure that the input isn't empty
					if($file){
						$image = mysqli_real_escape_string($con, file_get_contents($_FILES['school_image']['tmp_name']));
						$image_name = mysqli_real_escape_string($con, $_FILES["school_image"]['name']);
						$image_size = getimagesize($_FILES['school_image']['tmp_name']);
						
						// makes sure that the file is an image
						if($image_size){
							$image_data[] = $image;								
						}
						else 
						{
							$errors[] =  "You may only select images!";	
						}
						
					}
					else
					{
						$change_image = true;
					}
				}
				else
				{
					$errors[] = "Image not found, please try again";
				}
				
				if(sizeof($errors) == 0) {
					$date = secure_str(date("Y-m-d H:i:s"));
					
					$query = "UPDATE school SET info='$info', school_name = '$name' WHERE school_id = '$school_id'";
					$result = mysqli_query($con, $query) or die (mysqli_error($con));
					
					if(!$result) {
						$errors[] = "Failed to connect to database, please try again";
					}
					
					// checks if an image has been selected
					if(isset($image)){
						$query = "UPDATE school SET info_image='$image' WHERE school_id = '$school_id'";	
						$result = mysqli_query($con, $query) or die (mysqli_error($con));
						
						if(!$result) {
							$errors[] = "Failed to connect to database, please try again. Image may be too big.";
						}
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