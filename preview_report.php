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
	
	<?php		
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
				<div class = "info_bar">
					<a class = 'back_button' href = "reports.php">Back to reports</a> 
				</div>
			
			<?php
			if(isset($_GET['report_id'])){
			$report_id = secure_str($_GET['report_id']);
			$select_report = get_report_by_id($con, $report_id);
			$data_report = mysqli_fetch_array($select_report);
			
			$report_id = $data_report['report_id'];
			
			// Gets the file
			$report_blob = $data_report['report_file'];
			$report_mime = $data_report['mime'];
			
			
			?>
			<h1 class = "learn_h1"><?php echo $data_report['report_name']; ?></h1>	
			<!--/ Gives the option to download the file in case the user is experiencing issues view it in the browser-->
			<p class = "center"> If you are having issues viewing the document, please consider <a href = "report_download.php?report_id=<?php echo $report_id; ?>">downloading</a> it and then viewing it. </p><?php
			
			echo '<object class ="preview" data="data:'.$report_mime.';base64,' . base64_encode( $report_blob ) . '" /><p>Your browser does not support PDF preview. Download the file instead or update your browser. </p></object>';
			}
			else{
			header("Location: reports.php");
			}
			?>
			</div>
			</div>
			
			</section>
			</body>
			
			</html>																																																																		