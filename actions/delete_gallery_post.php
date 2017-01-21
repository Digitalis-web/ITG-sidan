<?php
	session_start();
	include "../functions.php";
	
	$con = connect();
	
	$post_id = secure_str($_GET['id']);
	
	$post_select = get_gallery_post_by_id($con, $post_id);
	$post_data = mysqli_fetch_array($post_select);
	
	$creator_id = $post_data['account_id'];
	
	// makes sure that you're only removing your own post or if you are an admin
	if($creator_id == $_SESSION['account_id'] || $_SESSION['log_in'] > 1) {
		mysqli_query($con, "DELETE FROM gallery_post WHERE gallery_post_id = '$post_id'") or die (mysqli_error($con));
		
		// removes all the images from this post
		mysqli_query($con, "DELETE FROM gallery_image WHERE gallery_post_id = '$post_id'") or die (mysqli_error($con));
	}
	
	header("Location: ../gallery.php");
	
?>