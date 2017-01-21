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
		
		if(!isset($_SESSION['log_in']) || $_SESSION['log_in'] < 2){
			header("Location: index.php");
		}
		
	?>
	<body class = "">
		<section>
			
			<div id = "nav">
				<?php
					$home = "";
					$about = "";
					$experiences = "";
					$activites = "";
				$schools = "";
				$swe = "";
				require "nav.php";
				?>
			</div>
			
			<div class = "page_content">
			<div class = "admin_action_bar">
			<div class = "action_button">
			<a href = "admin_page.php?action=show_users">Show users</a>
			</div>
			
			<div class = "action_button">
			<a href = "admin_page.php?action=show_schools">Show schools</a>
			</div>
			</div>
			
			<div class = "users_list">
			
			
			
			<?php
			$con = connect();
			
			
			if(isset($_GET['action'])){
			$action = $_GET['action'];
			
			if($action == "show_users"){
			
			?>
			<div class = "list_object"> 
			<strong>
			<p> Name </p>
			<p> Email </p>
			<p> Type </p>
			<p> School</p>
			</strong>
			</div>
			<?php
			
			
			
			$accounts_select = get_all_accounts($con);
			
			while($account_data = mysqli_fetch_array($accounts_select)){
			$account_id = $account_data['account_id'];
			$name = ucwords($account_data['fname'] . " " . $account_data['lname']);
			$school_id = $account_data['school_id'];
			$email = $account_data['email'];
			
			$level = $account_data['level'];
			$type = "Student";
			
			if($level == 1){
			$type = "Teacher";
			}
			else if($level == 2){
			$type = "Admin";
			}
			
			
			$school_select = get_school_by_id($con, $school_id);
			$school_data = mysqli_fetch_array($school_select);
			
			$school_name = $school_data['school_name'];
			
			?>
			
			<div class = "list_object">  
			<p> <?php echo $name; ?> </p>
			<p> <?php echo $email; ?> </p>
			<p> <?php echo $type; ?> </p>
			<p> <?php echo $school_name; ?></p>
			</div>
			
			<?php
			}
			}
			else if($action == "show_schools"){
			?>
			<div class = "list_object"> 
			<strong>
			<p> Name </p>
			<p> ID </p>
			<p> Acronym </p>
			</strong>
			</div>							
			
			
			<?php
			
			$school_select = get_all_schools($con);
			
			while($school_data = mysqli_fetch_array($school_select)){
			$name = $school_data['school_name'];
			$school_id = $school_data['school_id'];
			$acronym = $school_data['acronym'];
			
			?>
			
			<div class = "list_object">  
			<p> <?php echo $name; ?> </p>
			<p> <?php echo $school_id; ?> </p>
			<p> <?php echo $acronym; ?> </p>
			</div>
			
			<?php
			
			}
			
			}
			
			}
			?>
			
			</div>
			
			</div>
			
			</section>
			</body>
			
			</html>																																						