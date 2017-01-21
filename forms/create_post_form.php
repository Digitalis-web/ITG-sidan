<?php
	// if the meeting variable is set to 1 then a meeting should be created instead of a regualar post
	if(isset($_GET['meeting']) && $_GET['meeting'] == 1) {
		$is_meeting = true;
	}
	else {
		$is_meeting = false;
	}
?>

<div class = "form wide_form center_vertical ">
	<form id = "form" method = "post" enctype="multipart/form-data">
		
		
		<h1>
			<?php 
				if($is_meeting){
					echo "Create meeting";
				}
				else{
					echo "Create post";
				}
				
			?>
			
		</h1>
		
		<?php 
			// If this is a 'meetings-post' then an extra variable will be added to the form which will tell the create page that this is a "meetings-post"
			if($is_meeting){
				echo "<input type ='hidden' name = 'is_meeting'>";
			}
		?>
		
		<div id = "ajax_info">
			<br>
		</div>
		<input type = "text" name = "title" placeholder = "Title">
		<h3>Cover image: </h3>
		<input type = "file" name = "image0">
		<textarea oninput = "" id = "content" type = "content" name = "content" placeholder = "Content"></textarea>
		
		<h3>Text image: </h3>
		<div id = "file_inputs_container"> <!-- Container for all the input elements that will be created here automaticly from javascript --->
			<input type = "file" name = "image1" onchange="addImageInput(event)">
		</div>
		
	</form>
	
	<input type = "submit" id = "create" value = "Create" onclick = "create_post()">
	</div>
				