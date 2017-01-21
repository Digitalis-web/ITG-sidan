<?php
	session_start();
	include "functions.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ITG</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="js/script.js" type="text/javascript"></script>
		<script src="js/ajax_functions.js" type="text/javascript"></script>
		<script src="js/ajax_validation.js" type="text/javascript"></script>
		
		
		<!-- JS plugin to make vw unit work in older browser and Safari-->
		<script src="js/viewport-units-buggyfill.js"></script>
		<script src="js/viewport-units-buggyfill.hacks.js"></script>
		<script>window.viewportUnitsBuggyfill.init({
			// ignore browser capability, run this puppy everywhere
			force: true,
			// milliseconds to delay between updates of viewport-units
			// caused by orientationchange, pageshow, resize events
			refreshDebounceWait: 250,
			hacks: window.viewportUnitsBuggyfillHacks
		});</script>
		
		<meta charset = "utf-8">
	</head>
	
	
	
	<section>
		<div id = "nav">
			<?php
				$home = "";
				$about = "";
				$experiences = "";
				$activites = "";
				$schools = "class='highlight'";
				$swe = "";
				include "nav.php";
			?>
		</div>
		
		<div class = "page_content">
			
			<div class = "posts_container">
				<?php
					$con = connect();
					$school_id = $_GET['school_id'];
					
					$school_select = get_school_by_id($con, $school_id);
					$school_data = mysqli_fetch_array($school_select);
					$name = $school_data['school_name'];
				$info = $school_data['info'];
				
				?>
				<div class = "info_bar">
				<h1>
				<?php 
				if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode'])
				{
				?>
				<div id = "ajax_info"></div>
				<form id = "update_form" method = "post" enctype="multipart/form-data">
				<input type = "hidden" value = "<?php echo $school_id; ?>" name = "school_id">
				<input type = "text" value = "<?php echo $name; ?>" name = "name" placeholder = "School name">
				<?php
				}
				else {
				echo $name;
				}
				
				
				?>
				</h1>
				</div>
				<div class = "post_split school_info school_left">
				<p>
				<?php 
				if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode'])
				{
				?>
				<textarea id = "info" class = "textarea_update" type = "text"  name = "info" placeholder = "Info about this school">
				
				</textarea>
				
				<!-- Starts script to set the previous text into the textarea. This is only when you are in editor_mode-->
				<script>
				var info = "<?php echo $info; ?>";
				info = decode_content(info);
				info = info.replace(/\<br\>/g, "\n");
				
				document.getElementById("info").value = info;
				
				</script>
				<?php
				}
				else 
				{
				?>
				<script>
				// Decodes content and then prints to page
				var info = "<?php echo $info; ?>";
				info = decode_content(info); // formats the text
				
				document.write(info); // prints the text on the page
				
				</script>
				<?php
				}
				?>
				</p>
				</div>
				
				<div class = "post_split school_right">
				<img class = "school_image" src = "actions/get_school_image.php?school_id=<?php echo $school_id; ?>">
				<?php
				if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode']){
				?>
				<input type = "file" name = "school_image">
				<?php
				}
				?>
				</div>
				
				<?php
				
				if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode']){
				?>
				</form>
				<input type = "submit" value = "Apply updates" onclick = "update_school_info()">
				<?php
				}
				
				?>
				
				
				
				
				</div>
				
				
				
				</div>
				
				</section>
				
				
				</html>																																																																																																																																																																																																	