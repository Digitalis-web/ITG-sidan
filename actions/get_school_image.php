<?php
	include "../db_connect.php";
	$con = connect();
	
	$school_id = mysqli_real_escape_string($con, $_REQUEST['school_id']);
	
	$query = "SELECT * FROM school WHERE school_id = '$school_id'";
	$select = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_assoc($select);
	
	$image = $data['info_image'];
	
	
	header("Content-type: image/jpg");
	echo ($image);
	
?>