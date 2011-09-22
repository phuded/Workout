<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<script>
		
		</script>
		<?php
			//Connect To Database
			include 'config.php';
			date_default_timezone_set('GMT');
		?>
		
	</head>
<body>
	<div class="container">
		<div class="header">
			<div class="innerHeader">
				<div class="logo">
					<span>Workout Planner</span>
				</div>
				<div class="menuPanel">
					<ul id="menu" class="menu">
						<li class="menu-item">
							<a href="." class="selected">Upcoming Workouts</a>
						</li>
						<li class="menu-item">
							<a href="exercises.php">exercises</a>
						</li>
						<li class="menu-item">
							<a href="#">schedule</a>
						</li>
					</ul>
				</div>
			</div>	
		</div>
		<div class="content">
			<div class="page-content">
				<h2>Training Programme</h2>
				<?php
				
					$sql = 'select e.name as exercise, ws.reps as reps, ws.weight as weight, ws.order as setnum, we.date as date, w.location as location from weights_set ws, workout_exercise we, workout w, exercise e'
							. ' where'
							. ' ws.workout_exercise_id = we.id and'
							. ' we.workout_id = w.id and'
							. ' we.exercise_id = e.id';
					
					//Default
					$defaultDir = 'asc';
					$eDir = $defaultDir;
					$rDir = $defaultDir;
					$wDir = $defaultDir;
					$sDir = $defaultDir;
					$dDir = $defaultDir;
					$lDir = $defaultDir;
											
					if(isset($_GET[orderby])){						
						//Flip direction for link
						if($_GET[dir] == 'asc'){
							$direction = 'desc';
						}
						else{
							$direction = 'asc';
						}					
						
						switch ($_GET[orderby]) {
							case 'exercise':
								$eDir = $direction;
								break;
							case 'reps':
								$rDir = $direction;
								break;
							case 'weight':
								$wDir = $direction;
								break;
							case 'setnum':
								$sDir = $direction;
								break;
							case 'date':
								$dDir = $direction;
								break;
							case 'location':
								$lDir = $direction;
								break;
						}
												
						$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
					};
										
					$result = mysql_query($sql);

					echo '<table class="weights">'.
						 '<tr>'.
							'<th><a href="?orderby=exercise&dir='.$eDir.'">Exercise</a></th>'.
							'<th><a href="?orderby=reps&dir='.$rDir.'">Reps</a></th>'.
							'<th><a href="?orderby=weight&dir='.$wDir.'">Weight</a></th>'.
							'<th><a href="?orderby=setnum&dir='.$sDir.'">Set Number</a></th>'.
							'<th><a href="?orderby=date&dir='.$dDir.'">Start Time</a></th>'.
							'<th><a href="?orderby=location&dir='.$lDir.'">Location</a></th>'.
						 '</tr>';

					if($result) {
						while($row = mysql_fetch_array($result)){
							echo '<tr>'
								. '<td>' . $row['exercise'] . '</td>'
								. '<td>' . $row['reps'] . '</td>'
								. '<td>' . $row['weight'] . '</td>'
								. '<td>' . $row['setnum'] . '</td>'
								. '<td>' . $row['date'] . '</td>'
								. '<td>' . $row['location'] . '</td>'
								. '</tr>';
						}
					}

					echo '</table>';
				?>
			</div>	
		</div>
		<div class="footerGap"></div>
	</div>
	<div class="footer">
		<div class="footerTop">
		</div> 
		<br/>
		<p>&copy; Workout Planner</p>
	</div>
	
</body>
</html>
