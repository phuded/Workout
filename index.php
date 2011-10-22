<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/upcoming.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/show.js" type="text/javascript"></script>
		<script src="js/common.js" type="text/javascript"></script>
		<script src="js/graph/jquery.jqplot.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="js/graph/jquery.jqplot.min.css" />
		<script type="text/javascript" src="js/graph/plugins/jqplot.json2.min.js"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<?php
			include "functions/show.php";
		?>
		
	</head>
	<body>
		<div class="header">
				<div class="innerHeader">
					<div class="logo">
						<h1>Workout Planner</h1>
					</div>
					<div class="menuPanel">
						<ul id="menu" class="menu">
							<li class="menu-item">
								<a href="." class="selected">upcoming</a>
							</li>
							<li class="menu-item">
								<a href="workout.php">add workout</a>
							</li>
							<li class="menu-item">
								<a href="exercises.php">exercises</a>
							</li>
						</ul>
					</div>
				</div>	
		</div>
		<div class="content">
				<div class="page-content">
					<div id="workout" class="left-content h300">
						<h2>Upcoming Workouts</h2>
						<div class="inner-content">
							<?php showWorkouts($_REQUEST[orderby],$_REQUEST[dir]); ?>
						</div>
					</div>
					<div id="workoutExercise" class="right-content h300">
						<h2>Exercises</h2>
						<div class="inner-content">
							<p>Please click 'View' to load.</p>
						</div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="weightsSet_Planned" class="weights_set left-content">
						<h2>Planned Sets</h2>	
						<div class="inner-content">
							<p>Please click 'View Set' to load.</p>
						</div>
					</div>
					<div id="weightsSet_Actual" class="weights_set right-content">
						<h2>Actual Sets</h2>	
						<div class="inner-content">
							<p>Please click 'View Set' to load.</p>
						</div>
					</div>
					<div class="clear"></div>
					<div id="weightsSet_Graph" style="display:none;">
						<h2>Set Comparison</h2>	
						<div id="graph" style="height:400px;"></div>
						<a href="javascript:$.showGraph(false);">Close Graph</a>
					</div>
				</div>				
		</div>
	</body>
</html>
