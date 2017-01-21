<?php
	
	if(!isset($_SESSION)){
		session_start();
	}
	
	
	if(isset($_SESSION['log_in'])){
		$name = ucwords($_SESSION['fname']) ." ". ucwords($_SESSION['lname']);
		
		echo "<p>Logged in as <strong>" . $name ." </strong> <br></p>";
		//echo "Click <a onclick = 'logout()'>here</a> to log out </p>";
		echo "<div onclick = 'logout()' class = 'button margin_top_20'>Logout</div>";
		
		// If you are logged in as admin
		if ($_SESSION['log_in'] == 2) {
			
			if($_SESSION['editor_mode']){
				echo "<div class = 'button bigger_button'> <a href ='actions/toggle_edit_mode.php'> Exit editor mode </a> </div>";
			}
			else{
				echo "<div class = 'button bigger_button'> <a href ='actions/toggle_edit_mode.php'> Enter editor mode </a> </div>";
			}
			
			echo "<div class = 'button admin_button'> <a href ='admin_page.php'> Admin page</a> </div>";
		}
		
	}
	else {
		echo "<p>Are you a member of this project? </p><div class = 'button margin_top_20' onclick = 'open_log_in_form()'>Login</div>";
	}
	
?>	