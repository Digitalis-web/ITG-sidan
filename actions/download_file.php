<?php
	$name = $_GET['name'];
	$mime = $_GET['mime'];
	$data = $_GET['data'];
	
	header("Content-length: strlen($filedata); Content-type: " . $mine.  "Content-disposition: download; filename = ".$name);
	echo $data;
?>