<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/main.js" type="text/javascript"></script>
		<script src="js/graph/jquery.jqplot.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="js/graph/jquery.jqplot.min.css" />
		<script type="text/javascript" src="js/graph/plugins/jqplot.json2.min.js"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<?php
			include "functions/show.php";
		?>
		<script>
			$(document).ready(function() {
				$( "#datepicker" ).datepicker({
					numberOfMonths: 2,
					dateFormat: 'dd/mm/yy', 
					showButtonPanel: true,
					showAnim: 'blind'
				});
				
				$.showEditTable("workout");
			});
		</script>
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
								<a href=".">upcoming</a>
							</li>
							<li class="menu-item">
								<a href="workout.php" class="selected">add workout</a>
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
					<div id="newWorkout" class="left-content">
						<h2>1. Create new workout</h2>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
								<label for="location">Location:</label>
								<select type="text" name="location" id="location">
											<option value="v_epsom">Virgin Active - Epsom</option>
											<option value="v_merton">Virgin Active - Merton Abbey</option>
											<option value="v_stranf">Virgin Active - The Strand</option>
								</select>
								<br/><br/>
								<label for="datepicker">Date:</label>
								<input id="datepicker" type="text">
								<label for="timehr">Time:</label>
								<input id="timehr" type="text" MAXLENGTH=2 SIZE=1>:<input id="timemn" type="text" MAXLENGTH=2 SIZE=1>
								<br/><br/>
								<label for="duration">Duration:</label>
								<input id="duration" type="text" MAXLENGTH=3 SIZE=2> mins.
								<br/><br/>
								<input type="submit" value="Create/Update"/>&nbsp;&nbsp;<input type="reset" value="Reset/Unselect workout"/>
						</form>
					</div>
					<div id="workout" class="right-content">
						<h2>or choose existing...</h2>
						<div class="inner-content"></div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="workoutExercise" class="left-content">
						<h2>2. Selected Exercises</h2>
						<div class="inner-content"></div>
					</div>
					<div id="exercise" class="right-content">
						<h2>Available Exercises</h2>
						<div class="inner-content"></div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="weightsSet_Planned" class="left-content">
						<h2>3. Planned Sets</h2>
						<div class="inner-content"></div>
					</div>
					<div id="weightsSet_Actual" class="right-content">
						<h2>Actual Sets</h2>
						<div class="inner-content"></div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="form_weightsSet_Planned" class="left-content">
						<p><b>Add Planned Set</b></p>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<label for="order">Order:</label>
							<input id="order" type="text" MAXLENGTH=2 SIZE=1>
							<br/><br/>
							<label for="numReps">Number of Reps:</label>
							<input id="numReps" type="text" MAXLENGTH=2 SIZE=1>
							&nbsp;&nbsp;
							<label for="weight">Weight:</label>
							<input id="weight" type="text" MAXLENGTH=3 SIZE=2> KG
							<br/><br/>
							<input type="submit" value="Add"/>&nbsp;&nbsp;<input type="reset" value="Reset values"/>
						</form>
					</div>
					<div id="form_weightsSet_Actual" class="left-content">
						<p><b>Add Actual Set</b></p>
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<label for="order">Order:</label>
							<input id="order" type="text" MAXLENGTH=2 SIZE=1>
							<br/><br/>
							<label for="numReps">Number of Reps:</label>
							<input id="numReps" type="text" MAXLENGTH=2 SIZE=1>
							&nbsp;&nbsp;
							<label for="weight">Weight:</label>
							<input id="weight" type="text" MAXLENGTH=3 SIZE=2> KG
							<br/><br/>
							<input type="submit" value="Add"/>&nbsp;&nbsp;<input type="reset" value="Reset values"/>
						</form>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="save">
						<input type="submit" value="Create/Update"/>
					</div>
				</div>				
		</div>
	</body>
</html>