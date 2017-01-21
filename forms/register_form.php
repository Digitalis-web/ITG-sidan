
<div class = "form center_vertical ">
	<form id = "form" method = "post" enctype="multipart/form-data">
		<h1>Register</h1>
		
		<div id = "ajax_info"><br></div>
		<p onclick = "open_log_in_form()"> Got an account already?</p>
		
		<input type = "text" id = "email" name = "email" placeholder = "Email *">
		<input type = "text" id = "fname" name = "fname" placeholder = "Firstname *">
		<input type = "text" id = "lname" name = "lname" placeholder = "Lastname *">
		<input type = "text" id = "school_code" name = "access_code" placeholder = "Access code *"><br>
		<select name="school_id">
		<option value="" disabled selected>Select your school</option>
			<?php
				include "../functions.php";
				$con = connect();
				
				$select_schools = get_all_schools($con);
				
				while($data_school = mysqli_fetch_array($select_schools)){
					$school_id = $data_school['school_id'];
					$school_name = $data_school['school_name'];
					
					
					echo "<option value='$school_id'>$school_name</option>";
				}				
			?>
		</select>
		<br>
		
		<input type = "password" id = "password" name = "password" placeholder = "Password *">
		<input type = "password" id = "password_repeat" name = "password_repeat" placeholder = "Password repeat *">
		
	</form>
	<input type = "submit" onclick = "register()" value = "Register" id = "register">
	
</div>



