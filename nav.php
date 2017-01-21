
<head>
	<link href="css/nav.css" rel="stylesheet" type="text/css">
</head>


<div class = "hori_line">
	<div class = "project_name center_verti"><strong>EWEMC</strong></div>
	
	<ul id="drop_nav">
		<li><a <?php echo $home; ?> href="index.php"><p class = "nav_p">Home</p></a></li>
		<li><a <?php echo $about; ?> href="index.php?version=about"><p class = "nav_p">About</p></a></li>
		<li><a <?php echo $experiences; ?> href="experiences.php"><p class = "nav_p">Experiences</p></a></li>
		<li><a <?php echo $activites; ?> href = "reports.php"><p class = "nav_p">Activities</p></a>
			<ul>
				<li><a href="reports.php">Reports</a></li>
				<li><a href="experiences.php?show_meetings=meetings">Meetings</a></li>
				<li><a href="gallery.php">Gallery</a></li>
			</ul>
		</li>
		<li><a  href ="school.php?school_id=1"<?php echo $schools; ?>><p class = "nav_p">Schools</p></a>
			<ul>
				<?php
					include "functions.php";
					$con = connect();
					
					$school_select = get_all_schools($con);
					
					while($school_data = mysqli_fetch_array($school_select)){
						$name = $school_data['school_name'];
						$acronym = $school_data['acronym'];
						$school_id =  $school_data['school_id'];
						echo "<li><a href='school.php?school_id=$school_id'>$acronym</a></li>";
					}
					
				?>
			</ul>
		</li>
		<li><a <?php echo $swe; ?> href="learnswe.php"><p class = "nav_p">Learn Swedish</p></a></li>
	</ul>
</div>


<div class = "login_info">
	<?php
		include "log_in_info.php";
	?>
</div>

<div onclick = "close_form(event)" id = "form_container">
	
</div>



