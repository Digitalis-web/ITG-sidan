<?php
	
	function connect(){
		$con = mysqli_connect("localhost", "fcclftva_root", "qwerty123", "fcclftva_itg2");
		mysqli_set_charset($con, "utf-8");
		return $con;
	}
	
?>