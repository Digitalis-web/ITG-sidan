<?php
	session_start();
	require "functions.php";
	
?>

<!DOCTYPE html>
<?php
	/* Since the about-page and the index-page are almost exactly the same, they will share document and when the
		about page is to be viewed, a GET argument will be passed in the URL. The text content of these pages are stored in the
		database in the "page_text"-table. The reason for this is to allow admins to more easily change the content of these pages by 
		entering "editor mode".
		
	*/
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>EWEMC</title>
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
	
	
	<body class = "image_background">
		<section>
			
			<div id = "nav">
				<?php
					
					if(isset($_GET['version']) && $_GET['version'] == "about"){
						$about = "class='highlight'";		
						$home = "";
						$page = "about";
					}
					else{
						$home = "class='highlight'";
						$about = "";
						$page = "index";
					}
					$experiences = "";
					$activites = "";
					$schools = "";
					$swe = "";
					require "nav.php";
				?>
			</div>
			
			<div class = "page_content">
				<div class = "front_page_container">
					<?php
						$con = connect();
						
						$select_page = get_page_by_page($con, $page);
						$data_page = mysqli_fetch_array($select_page);
						
						$title = $data_page['title'];
						$info = $data_page['content'];
						
						if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode'])
						{
						?>
						<div id = "ajax_info"></div>
						<form id = "update_form" method = "post" enctype="multipart/form-data">
							<input type = "hidden" value = "<?php echo $page; ?>" name = "page_name">
							<input type = "text" value = "<?php echo $title; ?>" name = "title" placeholder = "Page title">
							<?php
							}
							else {
								echo "<h1 class = 'center'>" . $title . "</h1>";
							}
							
							if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode'])
							{
							?>
							<textarea id = "info" class = "textarea_update" type = "text"  name = "info" placeholder = "Page content">
								
							</textarea>
							
							<!-- Starts script to set the previous text into the textarea. This is only when you are in editor_mode-->
							<script>
								var info = "<?php echo $info; ?>";
								info = decode_content(info);
								info = info.replace(/\<br\>/g, "\n");
								
								document.getElementById("info").value = info;
								
							</script>
							<?php
							}
							else 
							{ // If you are not in editor mode
							?>
							<script>
								// Decodes content and then prints to page
								var info = "<?php echo $info; ?>";
								info = decode_content(info); // formats the text
								
								document.write("<p>" +info + "</p>"); // prints the text on the page
								
							</script>
							<?php
							}
							
							
							if(isset($_SESSION['editor_mode']) && $_SESSION['editor_mode']){
							?>
						</form>
						<input type = "submit" value = "Apply updates" onclick = "update_page_text()">
						<?php
						}
					?>
				</div>
				
			</div>
			<div class = "front_page_line">
				<div class = "logos_container"> 
					
					<div class = "logo_container">
						<img src = "img/logos/NORD.png" class = "logo center_hori" id = "NORD">
					</div>
					<div class = "logo_container">
						<img src = "img/logos/RVT.png" class = "logo center_hori" id = "RVT">
					</div>
					<div class = "logo_container">
						<img src = "img/logos/KTK.png" class = "logo center_hori" id = "KTK">
					</div>
					<div class = "logo_container">
						<img src = "img/logos/ITG.jpg" class = "logo center_hori" id = "ITG">
					</div>
					
					
				</div>
			</div>
		</section>
	</body>
	
</html>																																														