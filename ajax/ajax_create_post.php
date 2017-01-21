<?php
	
	session_start();
	include "../functions.php";
	
	
	
	// Makes sure the user is logged in
	if(isset($_SESSION['log_in'])) {
		$con = connect();
		
		if(isset($_POST['title']) && isset($_POST['content'])) {
			$image_data = []; // Stores the data of the images that are to be uploaded to the database
			$errors = [];
			
			$title = secure_str($_POST['title']);
			$content = secure_str($_POST['content']);
			$account_id = secure_str($_SESSION['account_id']);
			$cover_image = $_FILES['image0']['tmp_name']; // The cover image will always be image0
			
			
			// if this varable exists then this post is a 'meetings-post', otherwise it will just be a regular post
			if(isset($_POST['is_meeting'])){
				$is_meeting = 1;
			}
			else{
				$is_meeting = 0;
			}
			
			
			
			
			//$max_upload_size =  ini_get("upload_max_filesize");
			
			
			if(!$cover_image) {
				$errors[] = "No cover image selected. <br> -If this presists, it may be because the image is too large";
			}
			
			
			if(empty($title)) {
				$errors[] = "Title is empty";
			}
			
			if(empty($content)) {
				$errors[] = "Content is empty";
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
						
						
						$quality = 30;
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
					else
					{
						
						
					}
				}
				else
				{
					
				}
				
			}
			
			
			if(sizeof($errors) == 0) {
				$date = secure_str(date("Y-m-d H:i:s"));
				
				$query = "INSERT INTO post (title, content, account_id, creation_date, is_meeting) VALUES ('$title', '$content', '$account_id', '$date', '$is_meeting')";
				$result = mysqli_query($con, $query) or die (mysqli_error($con));
				$post_id = mysqli_insert_id($con); // Get id of inserted post
				
				$index = 0;
				
				foreach($image_data as $image){
					$query = "INSERT INTO post_image (data, post_id, image_index) VALUES ('$image', '$post_id', '$index')";	
					$result_img = mysqli_query($con, $query) or die (mysqli_error($con));
					if(!$result_img) {
						$errors[] = "There was an error uploading an images to the database. This may be because the image is too large or there might be something wrong with the PHP configuration";
					}
					$index++;
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