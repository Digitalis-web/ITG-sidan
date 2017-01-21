<?php
	/*
		Här finns alla funktioner som används, denna sidan inkluderas på alla andra sidor där funktioner behövs
		
		
		
	*/
	
	if(!isset($functions_included)){
		
		$functions_included = true;
		
		include "db_connect.php";
		
		// secures a string, protects against SQL injections and other attacks
		function secure_str($data){
			$con = connect();
			//$data = stripslashes($data);
			$data = trim($data);
			$data = addslashes($data);
			$data = mysqli_real_escape_string($con, $data);
			$data = strip_tags($data);	
			//	
			return $data;
		}
		
		
		
		
		function logout(){
			session_start();
			session_destroy();
		}
		
		
		function get_gallery_post_by_id($con, $id) {
			$id = secure_str($id);
			$query = "SELECT * FROM gallery_post WHERE gallery_post_id = '$id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_post_by_id($con, $id) {
			$id = secure_str($id);
			$query = "SELECT * FROM post WHERE post_id = '$id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_posts_with_offset($con, $start, $amount, $show_meetings) {
			$start = secure_str($start);
			$amount = secure_str($amount);
			$query = "SELECT * FROM post WHERE is_meeting = '$show_meetings' ORDER BY creation_date DESC LIMIT $amount OFFSET $start ";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		// There are two types of posts. The normal type is the unformal versions for the experiences-page and the formal one are for the meetings-page.
		// if $show_meetings is 0, then the unformal posts will be shown and the formal posts will be shown if $show_meetings is 1
		function get_all_posts($con, $show_meetings){
			$show_meetings = secure_str($show_meetings);
			$query = "SELECT * FROM post WHERE is_meeting = '$show_meetings'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		// Fetches an accounnt by ID
		function get_account_by_id($con, $account_id){
			$account_id = secure_str($account_id);
			$query = "SELECT * FROM account  WHERE account_id = '$account_id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}	
		
		// Fetches a school from the database by it's ID
		function get_school_by_id($con, $id) {
			$id = secure_str($id);
			$query = "SELECT * FROM school  WHERE school_id = '$id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_all_reports($con) {
			$query = "SELECT * FROM report ORDER BY date DESC";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_report_by_id($con, $report_id) {
			$report_id = secure_str($_GET['report_id']);
			$select_report = mysqli_query($con, "SELECT * FROM report WHERE report_id = '$report_id'") or die (mysqli_error($con));
			return $select_report;
		}
		
		function get_images_by_post_id($con, $post_id) {
			$post_id = secure_str($post_id);
			$query = "SELECT * FROM post_image WHERE post_id = '$post_id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		
		// This function tries to get a appropriate mime for the file format on the report. If a non supported file format is uploaded, it will return false
		function generate_report_mime($filename){
			if(ends_with($filename, ".pdf")){
				return "application/pdf";
			}
			else {
				return false;
			}
			
			/*else if(ends_with($filename, ".doc")){
				return "application/msword";
				}
				else if(ends_with($filename, ".dot")){
				return "application/msword";
				}
				else if(ends_with($filename, ".docx")){
				return "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
				}
				else if(ends_with($filename, ".dotx")){
				return "application/vnd.openxmlformats-officedocument.wordprocessingml.template";
				}
				else if(ends_with($filename, ".docm")){
				return "application/vnd.ms-word.document.macroEnabled.12";
				}
				else if(ends_with($filename, ".dotm")){
				return "application/vnd.ms-word.template.macroEnabled.12";
			}*/
		}
		
		function starts_with($haystack, $needle) {
			// search backwards starting from haystack length characters from the end
			return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
		}
		function ends_with($haystack, $needle) {
			// search forward starting from end minus needle length characters
			return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
		}
		
		function get_gallery_posts($con) {
			$query = "SELECT * FROM gallery_post";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_gallery_posts_with_offset($con, $start, $amount) {
			$start = secure_str($start);
			$amount = secure_str($amount);
			$query = "SELECT * FROM gallery_post ORDER BY date DESC LIMIT $amount OFFSET $start ";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_gallery_images($con, $post_id) {
			$post_id = secure_str($post_id);
			$query = "SELECT * FROM gallery_image WHERE gallery_post_id = '$post_id'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_page_by_page($con, $page){
			$page = secure_str($page);
			$query = "SELECT * FROM page_text WHERE page = '$page'";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_all_schools($con) {
			$query = "SELECT * FROM school";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function get_all_accounts($con) {
			$query = "SELECT * FROM account";
			$select = mysqli_query($con, $query) or die (mysqli_error($con));
			return $select;
		}
		
		function compress($source, $destination, $quality) { 
			$info = getimagesize($source); 
			
			if ($info['mime'] == 'image/jpeg') {
				$image = imagecreatefromjpeg($source); 
			}
			elseif ($info['mime'] == 'image/gif'){
				$image = imagecreatefromgif($source); 
			}
			elseif ($info['mime'] == 'image/png') {
				$image = imagecreatefrompng($source); 
			}
			imagejpeg($image, $destination, $quality); 
			return $destination; 
		}
		
		function return_bytes($val) {
			$val = trim($val);
			$last = strtolower($val[strlen($val)-1]);
			switch($last) {
				// The 'G' modifier is available since PHP 5.1.0
				case 'g':
				$val *= 1024;
				case 'm':
				$val *= 1024;
				case 'k':
				$val *= 1024;
			}
			
			return $val;
		}
		
		
		
	}
?>