<?php 
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	}

	include "functions/show.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/ui.jqgrid.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js" type="text/javascript"></script>
		<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
		<script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
		
		<script src="js/upcoming.js" type="text/javascript"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>		
	</head>
	<body>
		<div class="header">
			<div class="innerHeader">
				<div class="logo">
					<h1>Workout Planner</h1>
				</div>
				<img src="images/icon_dumbbells.png"/>
				<div class="menuPanel">
					<ul id="menu" class="menu">
						<li class="menu-item">
							<a href="." class="selected">upcoming</a>
						</li>
						<li class="menu-item">
							<a href="workout.php">plan workouts</a>
						</li>
						<li class="menu-item">
							<a href="exercises.php">exercises</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="login">Logged in as: <b><?php echo $_SESSION['username']; ?></b> <a href="logout.php">(logout)</a></div>				
		</div>
		<div class="content">
				<div class="page-content">
					<div id="workout" class="left-content h300">
						<h2>Upcoming Workouts</h2>
						<table id="workout_table"></table>
						<div id="workout_pager"></div>
					</div>
					<div id="workoutExercise" class="right-content h300">
						<h2>Exercises</h2>
						<table id="workoutExercise_table"></table>
						<div id="workoutExercise_pager"></div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="setPlanned" class="weights_set left-content">
						<h2>Planned Sets</h2>	
						<table id="setPlanned_table"></table>
					</div>
					<div id="setActual" class="weights_set right-content">
						<h2>Actual Sets</h2>	
						<table id="setActual_table"></table>
					</div>
				</div>				
		</div>
	</body>
</html>
