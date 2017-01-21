<?php
	include "../db_connect.php";
	$con = connect();
	
	$post_id = mysqli_real_escape_string($con, $_REQUEST['post_id']);
	$index = mysqli_real_escape_string($con, $_REQUEST['index']);

	

	$query = "SELECT * FROM post_image WHERE post_id = '$post_id' AND image_index = '$index'";
	$select = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_assoc($select);

	$image = $data['data'];

	
	header("Content-type: image/jpg");
	echo ($image);
	
?>