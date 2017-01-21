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
	
	<body class = "image_background_learn">
		<section>
			
			<div id = "nav">
				<?php
					$home = "";
					$about = "";
					$experiences = "";
					$activites = "";
					$schools = "";
					$swe = "class='highlight'";
					require "nav.php";
				?>
			</div>
			
			<div class = "page_content">
				<h1 class = "learn_h1">Simple Swedish phrases</h1>
				<div class = "learn_table">
					<div class = "learn_left learn_split">
						<h1>English</h1>
						<p>Hello</p>
						<p>Good day</p>
					</div>
					<div class = "learn_right learn_split">
					<h1>Swedish</h1>
					<p>Hej</p>
					<p>God dag</p>
					</div>
					</div>
					
					</div>
					
					</section>
					</body>
					
					</html>																								