<?php 
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:login.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/ui.jqgrid.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/workout.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/edit.js" type="text/javascript"></script>
		<script src="js/common.js" type="text/javascript"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<script type="text/javascript">
			$(document).ready(function() {
				$( "#datepicker" ).datepicker({
					numberOfMonths: 2,
					dateFormat: 'dd-mm-yy', 
					showButtonPanel: true,
					showAnim: 'blind'
				});
				
				$.showEditTable("workout");
				//Reset workout form
				document.workoutForm.reset();
				
				//$(".formButton").button();
			});
		</script>
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
								<a href=".">upcoming</a>
							</li>
							<li class="menu-item">
								<a href="workout.php" class="selected">plan workouts</a>
							</li>
							<li class="menu-item">
								<a href="exercises.php">exercises</a>
							</li>
						</ul>
					</div>
				</div>	
				<div class="login">Logged in as: <span><?php echo $_SESSION['username']; ?></span> <a href="logout.php">(logout)</a></div>	
		</div>
		<div class="content">
				<div class="page-content">
					<div id="form_workout" class="left-content h250">
						<h2>1. Create new workout</h2>
						<form id="workoutForm" name="workoutForm" action="javascript:$.updateWorkout();" method="get">
								<input type="text" id="workoutId" name="workoutId" style="display:none;"></input>
								<label for="location">Location:</label>
								<select type="text" name="location" id="location">
									<option value="Virgin Active Epsom">Virgin Active Epsom</option>
									<option value="Virgin Active Merton Abbey">Virgin Active Merton Abbey</option>
									<option value="Virgin Active Strand">Virgin Active Strand</option>
								</select>
								<br/><br/>
								<label for="datepicker">Date:</label>
								<input id="datepicker" type="text">
								<label for="timehr">Time:</label>
								<input id="timehr" type="text" MAXLENGTH=2 SIZE=1>:<input id="timemn" type="text" MAXLENGTH=2 SIZE=1>
								<br/><br/>
								<label for="duration">Duration (mins):</label>
								<input id="duration" type="text" MAXLENGTH=3 SIZE=2>
								&nbsp;&nbsp;<label for="shared">Shared:</label>
								<select type="text" name="shared" id="shared">
									<option value="shared">Shared</option>
									<option value="personal">Personal</option>
								</select>
								<br/><br/>
								<input class="formButton" type="submit" value="Create/Update" style="height:35px;font-weight:bold;"/>&nbsp;&nbsp;<input id="delWorkout" class="formButton" type="button" style="height:35px;" value="Delete workout" onClick="javascript:$.delWorkout();"/>
								<br/><br/>
								<input id="resetForm" class="formButton" style="height:25px;" type="reset" value="Reset/Unselect workout" onClick="javascript:$.unselectWorkout();"/>
						</form>
					</div>
					<div id="workout" class="right-content h250">
						<h2>or choose existing...</h2>
						<div class="inner-content"></div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="workoutExercise" class="left-content h300">
						<h2>2. Selected Exercises</h2>
						<div class="inner-content">
							<p>Please select a workout to load.</p>
						</div>
					</div>
					<div id="exercise" class="right-content h300">
						<h2>Available Exercises</h2>
						<div class="inner-content">
							<p>Please select a workout to load.</p>
						</div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="weightsSet_Planned" class="left-content h300">
						<h2>3. Planned Sets</h2>
						<div class="inner-content">
							<p>Please select an exercise to load.</p>
						</div>
					</div>
					<div id="weightsSet_Actual" class="right-content h300">
						<h2>Actual Sets</h2>
						<div class="inner-content">
							<p>Please select an exercise to load.</p>
						</div>
					</div>
					<div class="clear"></div>
					<div class="separator"></div>
					<div id="form_weightsSet_Planned" class="left-content">
						<p><b>Add Planned Set</b></p>
						<form name="weightsSetForm_Planned" action="javascript:$.addSet('Planned');" method="post">
							<label for="position_Planned">Position:</label>
							<select type="text" name="position_Planned" id="position_Planned" MAXLENGTH=2 SIZE=1></select>
							<br/><br/>
							<label for="numReps_Planned">Number of Reps:</label>
							<input id="numReps_Planned" class="set_form" type="text" MAXLENGTH=2 SIZE=1>
							&nbsp;&nbsp;
							<label for="weight_Planned">Weight:</label>
							<input id="weight_Planned" class="set_form" type="text" MAXLENGTH=3 SIZE=2> KG
							<br/><br/>
							<input type="submit" value="Add"/>&nbsp;&nbsp;<input type="reset" value="Reset values"/>
						</form>
					</div>
					<div id="form_weightsSet_Actual" class="right-content">
						<p><b>Add Actual Set</b></p>
						<form name="weightsSetForm_Actual" action="javascript:$.addSet('Actual');" method="post">
							<label for="position_Actual">Position:</label>
							<select type="text" name="position_Actual" id="position_Actual" MAXLENGTH=2 SIZE=1></select>
							<br/><br/>
							<label for="numReps_Actual">Number of Reps:</label>
							<input id="numReps_Actual" class="set_form" type="text" MAXLENGTH=2 SIZE=1>
							&nbsp;&nbsp;
							<label for="weight_Actual">Weight:</label>
							<input id="weight_Actual" class="set_form" type="text" MAXLENGTH=3 SIZE=2> KG
							<br/><br/>
							<input type="submit" value="Add"/>&nbsp;&nbsp;<input type="reset" value="Reset values"/>
						</form>
					</div>
					<div class="clear"></div>
					<br/>
					<br/>
				</div>				
		</div>
	</body>
</html>
