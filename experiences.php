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
				
				// If there's a get-variable 'show_meetings' then meetings should be shown instead of experiences
				if(isset($_GET['show_meetings'])){
					$show_meetings = 1;
				}
				else{
					$show_meetings = 0;
				}
				
				$home = "";
				$about = "";
				if($show_meetings == 0){
					$experiences = "class='highlight'";
					$activites = "";
				}
				else{
					$experiences = "";
					$activites = "class='highlight'";
				}
				$schools = "";
				$swe = "";
				include "nav.php";
			
			
			
			
			?>
			</div>
			
			<div class = "page_content">
			
			<div class = "info_bar">
			<?php
			if($show_meetings === 0){
			echo "<h1>Our students experiences</h1>";
			
			// checks if you are logged in
			if(isset($_SESSION['log_in'])){
			echo"
			<a class = 'create_post_link' onclick = 'open_create_post_form(0)'>Share your experiences!</a> 
			";
			}
			
			}
			else{
			echo "<h1>Meetings</h1>";
			
			// checks if you are logged in
			if(isset($_SESSION['log_in']) && $_SESSION['log_in'] > 0){
			echo"
			<a class = 'create_post_link' onclick = 'open_create_post_form(1)'>Create meeting!</a> 
			";
			}
			
			}
			
			?>
			</div>
			<div class = "posts_container">
			<?php
			$con = connect();
			
			
			$post_select = get_all_posts($con, $show_meetings);
			$num_posts = mysqli_num_rows($post_select);
			
			
			
			
			$posts_per_page = 5;
			
			// gets the current page of posts. If this is not set then it should just be page 0
			$current_page = 0;
			if(isset($_GET['page_num'])) {
			$current_page = $_GET['page_num'];
			}
			
			$start = $current_page * $posts_per_page;
			
			$post_select = get_posts_with_offset($con, $start, $posts_per_page, $show_meetings);
			
			while($post_data = mysqli_fetch_array($post_select))
			{
			$post_id = $post_data['post_id'];
			$title = $post_data['title'];
			$content = $post_data['content'];
			$creation_date = $post_data['creation_date'];
			
			// get information about the creator of this post
			$creator_id = $post_data['account_id'];
			$creator_select = get_account_by_id($con, $creator_id);
			$creator_data = mysqli_fetch_array($creator_select);
			$creator_name = ucwords($creator_data['fname'] . " " .$creator_data['lname']);
			
			$display_date = date("l j F Y", strtotime($creation_date)); // Reformats the date to: day of the week,day of month, month, year
			
			
			
			
			?>
			<div class = "single_post_container border_bottom">
			<div class = "post_split left_split">
			<p class = "post_title"><strong> <?php echo $title;?></strong></p>
			<p class = "post_small_p">By <?php echo $creator_name; ?></p>
			<p class = "post_small_p"><?php echo $display_date;?></p>
			<p class = "post_content"><script>
			var content = "<?php echo $content; ?>";
			var post_id = "<?php echo $post_id; ?>";
			
			content = decode_content(content, post_id, false, true);
			
			document.write(content); 
			</script></p>
			<div class = "post_read_more"><a href = "one_post.php?post_id=<?php echo $post_id; ?>"> <strong>Click to read more</strong></a></div>	
			</div>
			
			<div class = "post_split ">
			<div class = "post_image_container ">
			<!--<img src = "img/logos/ITG.jpg" class = "post_image">-->
			<?php
			/*$con = connect();
			// gets the cover image for this post
			$select_image = mysqli_query($con, "SELECT * FROM post_image WHERE post_id = '$post_id' AND image_index = '0'") or die (mysqli_error($con));
			$data_image = mysqli_fetch_array($select_image);
			$image_blob = $data_image['data'];*/
			?>
			<!--<img class = "post_image" src="data:image/jpg;base64, <?php echo base64_encode( $image_blob ); ?>" />-->
			<img src = "actions/get_post_image.php?post_id=<?php echo $post_id;?>&index=0" class = "post_image">		
			</div>							
			</div>
			
			
			
			</div>
			<?php
			
			}
			
			?>
			
			</div>
			
			
			<div class = "post_offset_container">
			<p>
			<?php					
			// The meetings_link will decide weather or the link to the next page will be for meetings or for experiences
			if($show_meetings == 1){
			$meetings_link = "&show_meetings";
			}
			else{
			$meetings_link = "";
			}
			
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
			$left_link = "<a href = 'experiences.php?page_num=$prev$meetings_link'>&lt</a> ";
			echo $left_link;
			}
			
			
			for($i = $start; $i < $stop; $i++){
			$link = "<a href = 'experiences.php?page_num=$i$meetings_link'>" . ($i+1) . "</a> ";
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
			$right_link = "<a href = 'experiences.php?page_num=$next$meetings_link'>&gt</a> ";
			echo $right_link;
			}
			
			
			?>
			</p>
			</div>
			
			
			</div>
			
			</section>
			
			
			</html>																																																																																																																		