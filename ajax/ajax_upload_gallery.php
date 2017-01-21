<?php
	session_start();	
	include "../functions.php";
	
	
	// Makes sure the user is logged in
	if(isset($_SESSION['log_in'])) {
		$con = connect();
		
		
		if(isset($_POST['title'])) {
			$image_data = []; // Stores the data of the images that are to be uploaded to the database
			$errors = [];
			
			$title = secure_str($_POST['title']);
			$account_id = secure_str($_SESSION['account_id']);
			
			
			
			
			if(empty($title)) {
				$errors[] = "Title is empty";
			}
			
			
			// Checks for up to 20 images. This number could be inscreased but 20 images seems like a reasonable amout for a post
			for ($i = 0; $i < 20; $i++) {
				
				//checks if this image exists in the form
				if(isset($_FILES['image' . $i])){						
					
					$file = $_FILES['image' . $i]['tmp_name'];
					
					// makes sure that the input isn't empty
					if($file){
						
						// gets the temporary storage file for the image
						$tmp_path = $_FILES['image' . $i]['tmp_name'];
						
						$quality = 40;
						// compresses the image
						$tmp_path = compress($tmp_path, $tmp_path, $quality);
						
						$image = mysqli_real_escape_string($con, file_get_contents($tmp_path));
						$image_name = mysqli_real_escape_string($con, $tmp_path);
						$image_size = getimagesize($tmp_path);
						
						// makes sure that the file is an image
						if($image_size){
							$image_data[] = $image;								
						}
						else 
						{
							$errors[] =  "You may only select images!";	
						}
						/*header("Content-type: image/jpeg");
						echo $image;*/
					}
				}			
			}
			
			
			if(sizeof($errors) == 0) {
				$date = secure_str(date("Y-m-d H:i:s"));
				
				$query = "INSERT INTO gallery_post (title, account_id, date) VALUES ('$title', '$account_id', '$date')";
				$result = mysqli_query($con, $query) or die (mysqli_error($con));
				
				if (!$result) {
					$errors[] = "Something went wrong when connecting to database. Please try again later";
				}
				
				$gallery_post_id = mysqli_insert_id($con); // Get id of inserted post
				
				
				
				foreach($image_data as $image){
					$query = "INSERT INTO gallery_image (image, gallery_post_id) VALUES ('$image', '$gallery_post_id')";	
					$result_img = mysqli_query($con, $query) or die (mysqli_error($con));
					if(!$result_img) {
						$errors[] = "There was an error uploading an images to the database. This may be because the image is too large or there might be something wrong with the PHP configuration";
					}
				}
				
			}
			
			
			
			if(sizeof($errors) == 0){ // If the post was sucessfully posted
				echo "true";
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
	
?>											