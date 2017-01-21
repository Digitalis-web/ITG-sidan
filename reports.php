<?php
	session_start();
	require "functions.php";
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ITG</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<!--	<link href="http://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css">-->
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
	
	<?php
		require "functions.php";
		session_start();
		$con = connect();
	?>
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
				<h1 class = "learn_h1">Reports</h1>	
				<div class = "reports_info_container">
					<p class = "reports_info">Here you can find reports from events during the project. Click on a report to open it in the browser or click the download button to download it.</p>
				</div>
				
				<form id = "reports_form" method = "post" enctype="multipart/form-data">
					
					<div id = "reports_ajax_info"></div>
					<?php
						// Make sure that you are a teacher or admin
						if(isset($_SESSION['log_in']) && $_SESSION['log_in'] > 0){
						?>
						<input type="file" name="report" id="file" class="input_report" onchange="upload_report()"/>
						<label for="file">Upload report</label>
						<?php
						}
					?>
				</form>
				<?php
					
					echo "<div class='reports_container'>";
					$select_reports = get_all_reports($con);
					// prints out all the reports in a list
					while ($data_reports = mysqli_fetch_array($select_reports)){
						$report_id = $data_reports['report_id'];
					?>
					<div class = "report_name">
						<img src = "img/PDF_icon.png">
						
					<a href = "preview_report.php?report_id=<?php echo $report_id; ?>"><?php echo $data_reports['report_name'];?></a></div>
					<div class = "report_download"><a href ="actions/report_download.php?report_id=<?php echo $report_id; ?>"> <img src ="img/download_button.png" class = "center_hori"></a></div>
					<?php
					}								
					?>
					</div>
					
					</div>
					
					
					
	</section>
</body>

</html>																																														