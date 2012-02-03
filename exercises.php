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
		
		<script src="js/exercises.js" type="text/javascript"></script>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<?php			
			if(isset($_POST[name])){
				$sql = "insert into exercise (name,type) values('$_POST[name]','$_POST[type]')";
				$result = mysql_query($sql);
			}
		?>
		
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
							<a href="workout.php">plan workouts</a>
						</li>
						<li class="menu-item">
							<a href="exercises.php" class="selected">exercises</a>
						</li>
					</ul>
				</div>
			</div>	
			<div class="login">Logged in as: <span><?php echo $_SESSION['username']; ?></span> <a href="logout.php">(logout)</a></div>	
		</div>
		<div class="content">
			<div class="page-content">
				<div id="exercise" class="left-content">
					<h2>All Exercises</h2>
					<table id="exercise_table"></table>
					<div id="exercise_pager"></div>
				</div>
				<div class="right-content">
					<h2>Add Exercise</h2>
					<div class="form">
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							Name: <input type="text" name="name" />
							Type: <select type="text" name="type">
										<option value="Biceps">Biceps</option>
										<option value="Triceps">Triceps</option>
										<option value="Deltoids">Deltoids</option>
										<option value="Shoulders">Shoulders</option>
										<option value="Chest">Chest</option>
										<option value="Abs">Abs</option>
										<option value="Back">Back</option>
										<option value="Legs">Legs</option>
									</select>
							<input type="submit" value="Add"/>
						</form>
					</div>
					<br/>
					<h2>Next Scheduled</h2>
					<div id="workoutExercise">
						<table id="workoutExercise_table"></table>
						<div id="workoutExercise_pager"></div>
					</div>
				</div>
			</div>	
		</div>
	</body>
</html>
