<?php
	include "functions.php";
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>EWEMC</title>
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
				$experiences = "class='highlight'";
				$activites = "";
				$schools = "";
				$swe = "";
				include "nav.php";
			?>
		</div>
		
		<div class = "page_content">
			
			<div class = "info_bar">
				<h1>Our students experiences</h1>
				<a class = 'back_button' href = "experiences.php">Back to experiences</a> 
			</div>
			
			<div class = "big_post_container">
				<?php
					$con = connect();
					$post_id = $_GET['post_id'];
					
				$post_select = get_post_by_id($con, $post_id);
				$post_data = mysqli_fetch_array($post_select);
				
				$title = $post_data['title'];
				$content = $post_data['content'];
				$creation_date = $post_data['creation_date'];
				$creator_id = $post_data['account_id'];
				
				$creator_select = get_account_by_id($con, $creator_id);
				$creator_data = mysqli_fetch_array($creator_select);
				$creator_name = ucwords($creator_data['fname'] ." ". $creator_data['lname']);
				
				$display_date = date("l j F Y", strtotime($creation_date)); // Reformats the date to: day of the week,day of month, month, year
				
				$can_edit = false;
				
				// makes sure that you are either an admin or that this is your post
				if(isset($_SESSION['account_id'])){
				if($creator_id === $_SESSION['account_id'] || $_SESSION['log_in'] > 0) {
				$can_edit = true;
				}
				}
				
				?>
				<p class = "post_title"><strong> <?php echo $title;?></strong></p>
				<p class = "post_small_p">By <?php echo $creator_name; ?></p>
				<p class = "post_small_p"><?php echo $display_date;?></p>
				<?php
				if($can_edit) {
				echo "<p class = 'post_small_p' onclick = 'delete_post($post_id)'> Click here to delete this post </a>";
				}
				?>
				<div class = "cover_image_container">
				<img src = "actions/get_post_image.php?post_id=<?php echo $post_id;?>&index=0">
				</div>
				<div>
				<div class = "post_content">
				<script>
				var content = "<?php echo $content; ?>";
				var post_id = "<?php echo $post_id; ?>";
				
				content = decode_content(content, post_id, true, false);
				
				document.write(content); 
				</script></div>
				
				
				</div>
				
				</section>
				
				
				</html>																																																																																																																																							