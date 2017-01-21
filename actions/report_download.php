<?php
	
	include "../functions.php";
	$con = connect();
	
	
	
	$report_id = secure_str($_GET['report_id']);
	$select_report = get_report_by_id($con, $report_id);
	$data_report = mysqlI_fetch_array($select_report); // gets the selected report from DB
	
	
	
	$report_name = $data_report['report_name'];
	$mime = $data_report['mime'];
	$filedata = $data_report['report_file'];
	
	//header("Content-length: strlen($filedata)");
	//$report_name .= ".pdf";
	
	//	header("Content-disposition: attachment; filename=); //disposition of download forces a download
	header('Content-Disposition: attachment; filename="'.$report_name.'"');
	header("Content-type: application/pdf");
	
	echo $filedata; 
	
	exit();
?>