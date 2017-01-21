<?php
	session_start();
	require "functions.php";
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>EWEMC</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="js/script.js" type="text/javascript"></script>
		<script src="js/ajax_functions.js" type="text/javascript"></script>
		<script src="js/ajax_validation.js" type="text/javascript"></script>
		
		<!-- JS plugin to make vw unit work in older browsers and Safari-->
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
	
	
	<body class = "">
		<section>
			
			<div id = "nav">
				<?php
					$home = "";
					$about = "";
					$experiences = "";
					$activites = "class='highlight'";
					$schools = "";
					$swe = "";
					require "nav.php";
				?>
			</div>
			
			<div class = "page_content">
				<h1 class = "learn_h1">Gallery</h1>
				<?php
					if(isset($_SESSION['log_in'])){
						?><div onclick = "open_gallery_form()" class = "smaller_button button gallery_button">Create post</div> <?php
					}
				?>
				<div class = "gallery_container">
					<?php
					
					
					$con = connect();
					
					$all_posts = get_gallery_posts($con);
					$num_posts = mysqli_num_rows($all_posts);
					
					
					
					$posts_per_page = 5;
					
					// gets the current page of posts. If this is not set then it should just be page 0
					$current_page = 0;
					if(isset($_GET['page_num'])) {
					$current_page = $_GET['page_num'];
					}
					
					$start = $current_page * $posts_per_page;
					
					$select_posts = get_gallery_posts_with_offset($con, $start, $posts_per_page); 
					
					// prints all the gallery_posts
					while($data_posts = mysqli_fetch_array($select_posts)){
					
					$post_id = $data_posts['gallery_post_id'];
					$post_title = $data_posts['title'];
					$post_date = $data_posts['date'];
					$display_date = date("l j F Y", strtotime($post_date)); // Reformats the date to: day of the week,day of month, month, year
					
					
					$creator_id = $data_posts['account_id'];
					$creator_select = get_account_by_id($con, $creator_id);
					$creator_data = mysqli_fetch_array($creator_select);
					$name = ucwords($creator_data['fname'] . " " . $creator_data['lname']);
					
					$can_delete = false;
					
					// checks if this is your post or if you are admin
					if(isset($_SESSION['log_in'])){
					if($creator_id == $_SESSION['account_id'] || $_SESSION['log_in'] > 1) {
					$can_delete = true;
					}
					}
					
					?>
					
					
					<div class = "gallery_post_container">
					<div class = "gallery_post_info"> <?php echo "<strong><p class ='post_title no_margin'>".$post_title . "</p></strong> <p class ='post_small_p'>". $display_date ."</p><p class ='post_small_p'>By ".$name."</p>"?></div>
					<div class = "gallery_images_container">
					<?php
					if($can_delete) {
					echo "<p class='delete_gallery' onclick = 'delete_gallery_post($post_id)'>Delete this post<p>";
					}
					
					$select_images = get_gallery_images($con, $post_id);
					
					// prints all images
					while($data_image = mysqli_fetch_array($select_images)){
					$blob = $data_image['image'];
					?>
					<div class = "gallery_image">
					<!-- Prints the image from database-->
					<img class = "center_verti center_hori_js" src="data:image/jpg;base64, <?php echo base64_encode( $blob ); ?>" />
					</div>
					
					<?php
					
					}
					
					?>
					</div>
					</div>
					
					<?php
					}
					
					?>
					
					</div>
					<div class = "post_offset_container">
					<p>
					<?php					
					
					
					$num_pages = ceil($num_posts / $posts_per_page);
					
					// decides how many pages that should be seen to the left of the current page on the page selector
					$num_prev_pages = $current_page;
					if($num_prev_pages >= 5){
					$num_prev_pages = 5;
					}
					
					// decides how many pages that should be seen to the right of the current page on the page selector
					$num_later_pages = $num_pages - $current_page;
					if($num_later_pages >=5 ){
					$num_later_pages = 5;
					}
					
					$start = $current_page - $num_prev_pages; // decides where to start the loop
					$stop = $current_page + $num_later_pages;
					
					// If this is the first page then there should not be an arrow to move to the previous page
					if($current_page != 0){
					$prev = $current_page -1;
					$left_link = "<a href = 'gallery.php?page_num=$prev'>&lt</a> ";
					echo $left_link;
					}
					
					
					for($i = $start; $i < $stop; $i++){
					$link = "<a href = 'gallery.php?page_num=$i'>" . ($i+1) . "</a> ";
					if($i == $current_page){
					echo "<strong>" . $link . "</strong>";
					}
					else{
					echo $link;
					}
					
					}
					
					// If this is the last page then there should not be an arrow to move to the next page
					if($current_page != ($num_pages-1)){
					$next = $current_page+1;
					$right_link = "<a href = 'gallery.php?page_num=$next'>&gt</a> ";
					echo $right_link;
					}
					
					
					?>
					</p>
					</div>
					
					</div>
					
					</section>
					</body>
					
					</html>																																								